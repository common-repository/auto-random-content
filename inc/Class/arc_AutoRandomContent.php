<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 20/01/18
 * Time: 21:25
 * Description :
 * This is the Main Class of plugin; There are create and delete method;
 * This Class works on custom table db too.
 */

class arc_AutoRandomContent
{
    ############### CONST ##################
    const number_of_user_must_be_create = 5;
    const number_of_terms_must_be_create = 5;
    const min_number_of_comment_must_be_created = 1;
    const max_number_of_comment_must_be_created = 8;

    ############### ATTR ###################
    private $plugin_option_data = null;
    private $post_taxs = null;
    private $tax = null;
    private $users = null;
    private $user = null;
    private $terms = null;
    private $term = null;
    private $posts_inserted = null;
    private $terms_inserted = null;
    private $medias_inserted = null;
    private $comments_inserted = null;
    private $users_inserted = null;

    ############## METHODS #################
    public function __construct()
    {
        $this->get_plugin_data();
        $this->setAction();
    }

    public function setAction()
    {
        add_action('wp_ajax_boot_delete', [$this, 'boot_delete']);
        add_action('wp_ajax_boot_create', [$this, 'boot_create']);
    }

    public function boot_create()
    {

        /* get the post taxs */
        $this->post_taxs = arc_Post::get_post_taxonomies($this->plugin_option_data['post_type']);

        /* if there are taxonomy set on post_type && if the option are set and if the option is checked*/
        if (count($this->post_taxs) > 0 && (!empty($this->plugin_option_data['relate_term'])) && ($this->plugin_option_data['relate_term'] == "checked")) {

            if (!empty($this->plugin_option_data['post_taxonomy']) && (in_array($this->plugin_option_data['post_taxonomy'], $this->post_taxs))) {
                $this->tax = $this->plugin_option_data['post_taxonomy'];
                for ($i = 0; $i < arc_AutoRandomContent::number_of_terms_must_be_create; $i++) {
                    $term = new arc_Term();
                    $this->terms_inserted[] = $term->insert($this->tax);
                    $term = null;
                }
                $this->terms = arc_Taxonomy::get_terms($this->tax);
            }

        }

        /* get users list */
        $this->users = arc_User::get_users_list();

        /* if there are less than 2 users i will create random users */

        for ($i = 0; $i < arc_AutoRandomContent::number_of_user_must_be_create; $i++) {
            $user = new arc_User();
            $this->users_inserted[] = $user->insert();
            $user = null;
        }
        /* update the users */
        $this->users = arc_User::get_users_list();

        for ($i = 0; $i < $this->plugin_option_data['post_number']; $i++) {

            /* get the author of post */
            $this->user = $this->get_random_user();

            /* insert post */
            $post = new arc_Post();
            $this->posts_inserted[] = $post->insert($this->plugin_option_data['post_type'], $this->user);

            /* here in the future we need to save all custom field */

            /* if the post_type have tax so..i want get the random term to assign  */
            if (!empty($this->tax)) {
                $this->term = $this->get_random_term();
                /* set term to post inserted */
                $post->set_term($this->posts_inserted[count($this->posts_inserted) - 1], $this->term->term_id, $this->tax);
            }

            if (!empty($this->plugin_option_data['relate_thumb']) && $this->plugin_option_data['relate_thumb'] == "checked" && $post->get_post_type_support($this->plugin_option_data['post_type'], 'thumbnail')) {
                /* create image thumb */
                $media = new arc_Media();
                $this->medias_inserted[] = $media->createImage($this->posts_inserted[count($this->posts_inserted) - 1]);
                $media = null;
                /* set image to post */
                $post->set_image($this->posts_inserted[count($this->posts_inserted) - 1], $this->medias_inserted[count($this->medias_inserted) - 1]);

            }

            /* ok, now it's time to comments */
            if (!empty($this->plugin_option_data['relate_comment']) && $this->plugin_option_data['relate_comment'] == "checked" && $post->get_post_type_support($this->plugin_option_data['post_type'], 'comments')) {
                $number_of_comments = $this->get_number_of_comments();
                for ($j = 0; $j < $number_of_comments; $j++) {
                    $comment = new arc_Comment();
                    $this->comments_inserted[] = $comment->insert($this->posts_inserted[count($this->posts_inserted) - 1], $this->get_random_user());
                    $comment = null;
                }
            }

            $post = null;
        }

        /* ################### REGISTER ON CUSTOM TABLE THE ID OF POST INSERTED ###################### */
        $managelogs = new arc_ManageLogs();
        if (!empty($this->posts_inserted)) {
            foreach ($this->posts_inserted as $post_inserted) {
                $managelogs->registerID($post_inserted, false, false, false, false);
            }
        }

        if (!empty($this->medias_inserted)) {
            foreach ($this->medias_inserted as $media_inserted) {
                $managelogs->registerID($media_inserted, true, false, false, false);
            }
        }

        if (!empty($this->terms_inserted)) {
            foreach ($this->terms_inserted as $term_inserted) {
                $managelogs->registerID($term_inserted, false, true, false, false);
            }
        }

        if (!empty($this->comments_inserted)) {
            foreach ($this->comments_inserted as $comment_inserted) {
                $managelogs->registerID($comment_inserted, false, false, true, false);
            }
        }

        if (!empty($this->users_inserted)) {
            foreach ($this->users_inserted as $user_inserted) {
                $managelogs->registerID($user_inserted, false, false, false, true);
            }
        }

        wp_die();
    }

    public function boot_delete()
    {
        $autorandomcontent_table = new arc_AutoRandomContentTable();
        $autorandomcontent_table_elements = $autorandomcontent_table->get_elements_of_custom_table();
        if (count($autorandomcontent_table_elements) > 0) {
            foreach ($autorandomcontent_table_elements as $element) {
                if (intval($element->is_media) == 1) {
                    $media = new arc_Media();
                    $media->delete(intval($element->id_post));
                    $media = null;
                } elseif (intval($element->is_term) == 1) {
                    $term = new arc_Term();
                    $term->delete(intval($element->id_post));
                    $term = null;
                } elseif (intval($element->is_comment) == 1) {
                    $comment = new arc_Comment();
                    $comment->delete(intval($element->id_post));
                    $comment = null;
                } elseif (intval($element->is_user) == 1) {
                    $user = new arc_User();
                    $user->delete(intval($element->id_post));
                    $user = null;
                } else {
                    $post = new arc_Post();
                    $post->delete(intval($element->id_post));
                    $post = null;
                }
            }
            $autorandomcontent_table->clear_table();
        }
        wp_die();
    }

    private function get_plugin_data()
    {
        /* READ INFORMATION ABOUT OPTION PAGE [ NUMBER OF POSTS THAT MUST CREATED AND THE POST TYPE ]  */
        $this->plugin_option_data = get_option('random_content_option_name');
    }

    private function get_random_user()
    {
        $index = rand(0, count($this->users) - 1);

        return $this->users[$index];
    }

    private function get_random_term()
    {
        $index = rand(0, count($this->terms) - 1);

        return $this->terms[$index];
    }

    private function get_number_of_comments()
    {
        return rand(arc_AutoRandomContent::min_number_of_comment_must_be_created, arc_AutoRandomContent::max_number_of_comment_must_be_created);
    }
}