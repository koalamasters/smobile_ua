<?php
/**
 * @copyright    OCTemplates
 * @support      https://octemplates.net/
 * @license      LICENSE.txt
 */

class ControllerExtensionModuleOCTBlogCategory extends Controller {
    public function index() {
        if (!$this->config->get('oct_blogsettings_status')) {
            return;
        }

        $this->load->language('octemplates/module/oct_blogcategory');

        if (isset($this->request->get['blog_path'])) {
            $parts = explode('_', (string)$this->request->get['blog_path']);
        } else {
            $parts = [];
        }

        if (isset($parts[0])) {
            $data['blogcategory_id'] = $parts[0];
        } else {
            $data['blogcategory_id'] = 0;
        }

        if (isset($parts[1])) {
            $data['blogchild_id'] = $parts[1];
        } else {
            $data['blogchild_id'] = 0;
        }

        $this->load->model('octemplates/blog/oct_blogcategory');

        $this->load->model('octemplates/blog/oct_blogarticle');

        $data['search_block'] = $this->config->get('oct_blogsettings_search') ? true : false;

        $data['blog_categories'] = [];

        $blog_categories = $this->model_octemplates_blog_oct_blogcategory->getBlogCategories(0);

        foreach ($blog_categories as $blog_category) {
            $children_data = [];

            $children = $this->model_octemplates_blog_oct_blogcategory->getBlogCategories($blog_category['blogcategory_id']);

            foreach($children as $child) {
                $filter_data = array('filter_blogcategory_id' => $child['blogcategory_id'], 'filter_sub_blogcategory' => true);

                $children_data[] = array(
                    'blogcategory_id' => $child['blogcategory_id'],
                    'name' => $child['name'] . ($this->config->get('oct_blogsettings_count_articles') ? ' (' . $this->model_octemplates_blog_oct_blogarticle->getTotalArticles($filter_data) . ')' : ''),
                    'href' => $this->url->link('octemplates/blog/oct_blogcategory', 'blog_path=' . $blog_category['blogcategory_id'] . '_' . $child['blogcategory_id'])
                );
            }

            $filter_data = [
                'filter_blogcategory_id'  => $blog_category['blogcategory_id'],
                'filter_sub_blogcategory' => true
            ];

            $current_category_href = $this->url->link('octemplates/blog/oct_blogcategory', 'blog_path=' . $blog_category['blogcategory_id']);

            $is_current_category = false;
            if (isset($this->request->get['blog_path'])) {
                $is_current_category = ($this->request->get['blog_path'] == $blog_category['blogcategory_id']);
            } else {
                $is_current_category = (strpos($this->request->server['REQUEST_URI'], '/blog') !== false);
            }

            $data['all_articles'] = $this->language->get('all_articles');


            $data['blog_categories'][] = [
                'blogcategory_id' => $blog_category['blogcategory_id'],
                'name'        => $blog_category['name'] == 'Блог' ?   $data['all_articles'] : $blog_category['name'],
                'count'       => ($this->config->get('oct_blogsettings_count_articles') ? $this->model_octemplates_blog_oct_blogarticle->getTotalArticles($filter_data) : ''),
                'children'    => $children_data,
                'href'        => $current_category_href,
                'active_class' => boolval($is_current_category) ? 'active' : ''
            ];

        }

        return $this->load->view('octemplates/module/oct_blogcategory_new', $data);
    }
}
