<?php

namespace app\components;

use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Menu;
use app\models\HrComplaint;
use app\models\HrFacility;
use app\models\IpqaPatrolTbl;
use app\models\ShiftPatrolTbl;

class SidebarMenu extends Widget
{
    public static function getMenu($roleId, $parentId=NULL){
        $output = [];
        foreach(Menu::find()->where(["parent_id"=>$parentId])->orderBy('order ASC')->all() as $menu){

            $obj = [
                "label" => $menu->name,
                "icon" => $menu->icon,
                "url" => SidebarMenu::getUrl($menu),
                "visible" => SidebarMenu::roleHasAccess($roleId, $menu->id),
            ];

            if ($menu->controller == 'hr-complaint' && $menu->action == 'index') {
                $total_waiting = HrComplaint::find()
                ->where([
                    'status' => 0,
                    'category' => 'HR',
                ])
                ->count();
                $obj = [
                    "label" => $menu->name,
                    "icon" => $menu->icon,
                    "url" => SidebarMenu::getUrl($menu),
                    "visible" => SidebarMenu::roleHasAccess($roleId, $menu->id),
                    'template' => '<a href="{url}">{icon} {label}<span class="pull-right-container"><small class="label pull-right bg-yellow">' . $total_waiting . '</small></span></a>',
                ];
            }

            if ($menu->controller == 'hr-facility' && $menu->action == 'index') {
                $total_waiting = HrFacility::find()
                ->where([
                    'status' => 0,
                ])
                ->count();
                $obj = [
                    "label" => $menu->name,
                    "icon" => $menu->icon,
                    "url" => SidebarMenu::getUrl($menu),
                    "visible" => SidebarMenu::roleHasAccess($roleId, $menu->id),
                    'template' => '<a href="{url}">{icon} {label}<span class="pull-right-container"><small class="label pull-right bg-yellow">' . $total_waiting . '</small></span></a>',
                ];
            }

            if ($menu->controller == 'hr-bpjs' && $menu->action == 'index') {
                $total_waiting = HrComplaint::find()
                ->where([
                    'status' => 0,
                    'category' => 'BPJS',
                ])
                ->count();
                $obj = [
                    "label" => $menu->name,
                    "icon" => $menu->icon,
                    "url" => SidebarMenu::getUrl($menu),
                    "visible" => SidebarMenu::roleHasAccess($roleId, $menu->id),
                    'template' => '<a href="{url}">{icon} {label}<span class="pull-right-container"><small class="label pull-right bg-yellow">' . $total_waiting . '</small></span></a>',
                ];
            }

            if ($menu->controller == 'mis-complaint' && $menu->action == 'index') {
                $total_waiting = HrComplaint::find()
                ->where([
                    'status' => 0,
                    'category' => 'MIS',
                ])
                ->count();
                $obj = [
                    "label" => $menu->name,
                    "icon" => $menu->icon,
                    "url" => SidebarMenu::getUrl($menu),
                    "visible" => SidebarMenu::roleHasAccess($roleId, $menu->id),
                    'template' => '<a href="{url}">{icon} {label}<span class="pull-right-container"><small class="label pull-right bg-yellow">' . $total_waiting . '</small></span></a>',
                ];
            }

            if ($menu->controller == 'ipqa-dashboard' && $menu->action == 'index') {
                $total_waiting = IpqaPatrolTbl::find()
                ->where([
                    'flag' => 1,
                ])
                ->andWhere(['<>', 'status', 1])
                ->andWhere(['>=', 'event_date', '2019-12-09'])
                ->count();
                $obj = [
                    "label" => $menu->name,
                    "icon" => $menu->icon,
                    "url" => SidebarMenu::getUrl($menu),
                    "visible" => SidebarMenu::roleHasAccess($roleId, $menu->id),
                    'template' => '<a href="{url}">{icon} {label}<span class="pull-right-container"><small class="label pull-right bg-red">' . $total_waiting . '</small></span></a>',
                ];
            }

            if ($menu->controller == 'shift-patrol-dashboard' && $menu->action == 'index') {
                $total_waiting = ShiftPatrolTbl::find()
                ->where([
                    'flag' => 1,
                ])
                ->andWhere(['<>', 'status', 1])
                ->count();
                $obj = [
                    "label" => $menu->name,
                    "icon" => $menu->icon,
                    "url" => SidebarMenu::getUrl($menu),
                    "visible" => SidebarMenu::roleHasAccess($roleId, $menu->id),
                    'template' => '<a href="{url}">{icon} {label}<span class="pull-right-container"><small class="label pull-right bg-red">' . $total_waiting . '</small></span></a>',
                ];
            }

            if(count($menu->menus) != 0){
                $obj["items"] = SidebarMenu::getMenu($roleId, $menu->id);
            }

            $output[] = $obj;
        }
        return $output;
    }

    private static function roleHasAccess($roleId, $menuId){
        $roleMenu = \app\models\RoleMenu::find()->where(["menu_id"=>$menuId, "role_id"=>$roleId])->one();
        if($roleMenu){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    private static function getUrl($menu){
        if($menu->controller == NULL){
            return "#";
        }else{
            return [$menu->controller."/".$menu->action];
        }
    }
}