<?php
/**
 * @package pr_: prmsn_hlp
 * @author Devotion Tech Team
 * @version 1.9
 * @abstract admin features helper
 * @copyright Devotion Tech
 */

use App\Models\BasePermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @author DevotionTech
 * @abstract function will check for permission of user for page where user going to be redirected
 * if permission not available for specific page then user redirected to page where logged in admin has permission
 * if no page available which particular user can access then user redirected to home page with message for asking to seek permission from super admin first.
 *
 */
	function adminRedirect( $admin_user_id, $class='', $isredirect=false )
	{
		if(!$isredirect)
		{
			if($class!='')
			{
				$res = DB::select("SELECT COUNT(p.id) as Count FROM permissions p
										INNER JOIN admin_menu m ON m.id=p.admin_menu_id
										WHERE m.class_name='".$class."' AND p.admin_user_id=".$admin_user_id." AND p.permission_view=0 ");

				if(!empty($res) && $res[0]->Count > 1)
				{
					$isredirect=true;
				}
			}
		}

		if(!$isredirect)
		{
			$res = DB::select("SELECT m.class_name FROM permissions p
									INNER JOIN admin_menu m ON m.id=p.admin_menu_id
									WHERE p.admin_user_id=".$admin_user_id." AND permission_view=0 LIMIT 1");

			if(!empty($res))
			{
				$isredirect=true;
				$class = $res[0]->am_class_name;
			}
		}

		if($isredirect)
		{
			redirect('admin/'.$class);
		}
		else
		{
			setFlashMessage( 'error', getErrorMessageFromCode('01021') );
			showPermissionDenied();
		}
	}

/*
 * @author   DevotionTech
 * @abstract function will check current admin user
 * @return true if yes else false
 */
function checkIsSuperAdmin( $admin_user_id, $is_power_admin=false )
{
	$res = "";
	if( !$is_power_admin )
	{
		$res = DB::select( "SELECT COUNT(g.id) as Count FROM admin_user_group g
								INNER JOIN users a ON a.user_group_id=g.id
								WHERE ( g.key='SUPER_ADMIN' OR g.key='POWER_ADMIN' ) AND a.id=".$admin_user_id );
	}
	else
	{
		$res = DB::select( "SELECT COUNT(g.id) as Count FROM admin_user_group g
								INNER JOIN users a ON a.user_group_id=g.id
								WHERE ( g.key='POWER_ADMIN' ) AND a.id=".$admin_user_id );
	}

	if(!empty($res) && $res[0]->Count >1 )
	{
		return true;
	}
	else
	{
		return false;
	}
}

/**
*+++++++++++++++++++++++++++++++++++++++++++++++++++++
*	@params : $controller  name of controller
*			  $per_type name of permission type to check
*
*	@return : array
*+++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
	function fetchPermission($controller="")
	{

		$admin_id = Auth::user()->id;
		if($admin_id == '' || $admin_id == 0)
		{
			redirect('./admin');
		}

		$sql = "SELECT p.permission_add,p.permission_edit,p.permission_delete,p.permission_view FROM permissions p INNER JOIN admin_menu m ON m.id=p.admin_menu_id WHERE p.admin_user_id=".$admin_id." AND m.class_name='".$controller."'";
		$res = DB::select($sql);

		if(!empty($res))
			return $res;
		else
			return '';

	}

	/**
	 * child segments handle permission
	 * @param string $controller
	 * @param string $permission
	 * @return unknown|number
	 */
	function fetchSinglePermission( $user, $controller="" , $permission = "view")
	{
		$admin_id = $user->id;

        $permissionObj = BasePermission::join('admin_menus', 'admin_menus.id', '=', 'base_permissions.admin_menu_id')
        ->select('base_permissions.id')
        // ->select('base_permissions.permission_add', 'base_permissions.permission_edit', 'base_permissions.permission_delete', 'base_permissions.permission_view')
        ->where( [
            'base_permissions.admin_user_id' => $admin_id,
            'admin_menus.class_name' => $controller,
            'permission_'.$permission => 1
        ] )
        ->first();

		if( $permissionObj )
		{
            return true;
			// if($permission == "view")
			// 	return $permissionObj->permission_view;
			// else if($permission == "add")
			// 	return $permissionObj->permission_add;
			// else if($permission == "edit")
			// 	return $permissionObj->permission_edit;
			// else if($permission == "delete")
			// 	return $permissionObj->permission_delete;
		} else {
            return false;
        }
	}


/*
++++++++++++++++++++++++++++++++++++++++++++++
	This function is setting error,notification,
	information message,
	keep data in session.
	@params :
		@Key : Key name of the variable
		@msg : Which message you want to dispaly
				in next page without pass query string.
++++++++++++++++++++++++++++++++++++++++++++++
*/
function setFlashMessage($key,$msg, $session=null)
{
	if($key && $msg != '')
		session('flash_'.$key, $msg);
}

/*
+------------------------------------------------------------------+
	Function is save admin log.
	@params : $className -> controller name
			  $itemName -> controller item name
			  $dbTableName -> name of db table
			  $dbTableField -> name of table field
			  $primaryId -> table primary id
			  $logType -> type of add/edit/delete
+------------------------------------------------------------------+
*/
function saveAdminLog($className, $itemName="", $dbTableName="", $dbTableField="", $primaryId=0, $logType="E")
{

	// $data = array(
	// 		'admin_user_id' => Auth::user()->id,
	// 		'admin_class_name' => @$className,
	// 		'module_item_name' => @$itemName,
	// 		'module_table_name' => @$dbTableName,
	// 		'module_table_field' => @$dbTableField,
	// 		'module_primary_id' => @$primaryId,
	// 		'admin_log_type' => @$logType,
	// 		'admin_log_ip' => @$CI->input->ip_address()
	// 		);

	// $CI->db->insert('admin_log', $data);

}

/**
 * @abstract Redirects user to default permission denied page if permission is not given
 */
function showPermissionDenied()
{
	$msg = getFlashMessage('error');
	if(empty($msg))
		setFlashMessage('error',getErrorMessageFromCode('01022'));
	else
		setFlashMessage('error',$msg);

	redirect('admin-panel/login');
}

/*
++++++++++++++++++++++++++++++++++++++++++++++
	This function is displaying error message,
	keep data in session.
	@params :
		@Key : Key name of the variable
++++++++++++++++++++++++++++++++++++++++++++++
*/
function getFlashMessage($key)
{
	$msg = '';
	if( session('flash_'.$key) != '' )
	{
		$msg = session('flash_'.$key);
		session('flash_'.$key, '');
	}

	return $msg;
}
?>
