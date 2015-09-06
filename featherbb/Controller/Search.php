<?php

/**
 * Copyright (C) 2015 FeatherBB
 * based on code by (C) 2008-2012 FluxBB
 * and Rickard Andersson (C) 2002-2008 PunBB
 * License: http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 */

namespace FeatherBB\Controller;

use FeatherBB\Core\Utils;
use FeatherBB\Core\Url;

class Search
{
    public function __construct()
    {
        $this->feather = \Slim\Slim::getInstance();
        $this->start = $this->feather->start;
        $this->config = $this->feather->config;
        $this->user = $this->feather->user;
        $this->request = $this->feather->request;
        $this->model = new \FeatherBB\Model\search();
        load_textdomain('featherbb', $this->feather->forum_env['FEATHER_ROOT'].'featherbb/lang/'.$this->user->language.'/userlist.mo');
        load_textdomain('featherbb', $this->feather->forum_env['FEATHER_ROOT'].'featherbb/lang/'.$this->user->language.'/search.mo');
        load_textdomain('featherbb', $this->feather->forum_env['FEATHER_ROOT'].'featherbb/lang/'.$this->user->language.'/forum.mo');
    }

    public function __autoload($class_name)
    {
        require $this->feather->forum_env['FEATHER_ROOT'] . $class_name . '.php';
    }

    public function display()
    {
        if ($this->user->g_read_board == '0') {
            throw new \FeatherBB\Core\Error(__('No view'), 403);
        } elseif ($this->user->g_search == '0') {
            throw new \FeatherBB\Core\Error(__('No search permission'), 403);
        }

        // Figure out what to do :-)
        if ($this->request->get('action') || ($this->request->get('search_id'))) {

            $search = $this->model->get_search_results();
                // We have results to display
                if (isset($search['is_result'])) {

                    if ($search['show_as'] == 'posts') {
                        require $this->feather->forum_env['FEATHER_ROOT'].'featherbb/Helpers/parser.php';
                    }

                    $this->feather->template->setPageInfo(array(
                        'title' => array(Utils::escape($this->config['o_board_title']), __('Search results')),
                        'active_page' => 'search',
                    ));

                    $this->model->display_search_results($search, $this->feather);

                    $this->feather->template->setPageInfo(array(
                        'search' => $search,
                    ));

                    $this->feather->template->addTemplate('search/header.php', 1);

                    if ($search['show_as'] == 'posts') {
                        $this->feather->template->addTemplate('search/posts.php', 5);
                    }
                    else {
                        $this->feather->template->addTemplate('search/topics.php', 5);
                    }

                    $this->feather->template->addTemplate('search/footer.php', 10)->display();

                } else {
                    redirect(Url::get('search/'), __('No hits'));
                }
        }
        // Display the form
        else {
            $this->feather->template->setPageInfo(array(
                'title' => array(Utils::escape($this->config['o_board_title']), __('Search')),
                'active_page' => 'search',
                'focus_element' => array('search', 'keywords'),
                'is_indexed' => true,
                'forums' => $this->model->get_list_forums(),
            ))->addTemplate('search/form.php')->display();
        }
    }

    public function quicksearches($show)
    {
        redirect(Url::get('search/?action=show_'.$show));
    }
}