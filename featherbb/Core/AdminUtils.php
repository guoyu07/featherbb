<?php

/**
 * Copyright (C) 2015-2016 FeatherBB
 * based on code by (C) 2008-2015 FluxBB
 * and Rickard Andersson (C) 2002-2008 PunBB
 * License: http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 */

namespace FeatherBB\Core;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class AdminUtils
{
    public static function generateAdminMenu($page = '')
    {
        translate('admin/common');

        \View::setPageInfo([
            'page'        =>    $page,
            'menu_items'  =>    Container::get('hooks')->fire('admin.menu', self::load_default_menu()),
            'plugins'     =>    self::adminPluginsMenu() // See if there are any plugins that want to be displayed in the menu
        ], 1
        )->addTemplate('admin/menu.php');
    }

    /**
     * Add plugin options to menu if needed
     */
    public static function adminPluginsMenu($isAdmin = false)
    {
        $menuItems = [];
        $menuItems = Container::get('hooks')->fire('admin.plugin.menu', $menuItems);

        return $menuItems;
    }

    /**
     * Generate breadcrumbs from an array of name and URLs
     */
    public static function breadcrumbs_admin(array $links)
    {
        foreach ($links as $name => $url) {
            if ($name != '' && $url != '') {
                $tmp[] = '<span><a href="' . $url . '">'.Utils::escape($name).'</a></span>';
            } else {
                $tmp[] = '<span>'.__('Deleted').'</span>';
                return implode(' » ', $tmp);
            }
        }
        return implode(' » ', $tmp);
    }

    /**
     * Delete a folder and all its content
     */
    public static function delete_folder($dirPath) {
        $it = new RecursiveDirectoryIterator($dirPath, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it,
            RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dirPath);
    }


    /**
     * Fetch admin IDs
     */
    public static function get_admin_ids()
    {
        if (!Container::get('cache')->isCached('admin_ids')) {
            Container::get('cache')->store('admin_ids', \FeatherBB\Model\Cache::get_admin_ids());
        }

        return Container::get('cache')->retrieve('admin_ids');
    }

    /**
     * Wrapper for cURL
     */
    public static function get_content($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "FeatherBB Marketplace");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $content = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($http_status != 200)
            return false;

        return $content;
    }

    protected static function load_default_menu()
    {
        return [
            'mod.index' => ['title' => 'Index', 'url' => 'adminIndex'],
            'mod.users' => ['title' => 'Users', 'url' => 'adminUsers'],
            'mod.bans' => ['title' => 'Bans', 'url' => 'adminBans'],
            'mod.reports' => ['title' => 'Reports', 'url' => 'adminReports'],
            'board.options' => ['title' => 'Admin options', 'url' => 'adminOptions'],
            'board.permissions' => ['title' => 'Permissions', 'url' => 'adminPermissions'],
            'board.categories' => ['title' => 'Categories', 'url' => 'adminCategories'],
            'board.forums' => ['title' => 'Forums', 'url' => 'adminForums'],
            'board.groups' => ['title' => 'User groups', 'url' => 'adminGroups'],
            'board.plugins' => ['title' => 'Plugins', 'url' => 'adminPlugins'],
            'board.censoring' => ['title' => 'Censoring', 'url' => 'adminCensoring'],
            'board.parser' => ['title' => 'Parser', 'url' => 'adminParser'],
            'board.maintenance' => ['title' => 'Maintenance', 'url' => 'adminMaintenance'],
            'board.updates' => ['title' => 'Updates', 'url' => 'adminUpdates']
        ];
    }
}
