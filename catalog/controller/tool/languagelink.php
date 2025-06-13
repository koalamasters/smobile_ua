<?php
class ControllerToolLanguagelink extends Controller {
    public function getLink($args )
    {


        $url = explode('?',$args[0])[0];
        $cur_lang = $args[1];
        $target_lang = $args[2];

        $cur_lang_href = explode('-', $cur_lang)[0];
        $target_lang_href = explode('-', $target_lang)[0];

/*
        echo "<pre style='display: none' id='kl_look_mp'>";
        print_r([
            $url,
            $cur_lang,
            $target_lang
        ]);
        echo "</pre>";
*/
        if(strpos($_SERVER['REQUEST_URI'], 'index.php') !== false){
            return [
                "$cur_lang_href" => $args[0],
                "$target_lang_href" => $args[0]
            ];
        }

        $url_parts = explode('/',$url);

        $this->load->model('tool/languagelink');
        $seo_links = $this->model_tool_languagelink->getSeoLinks();
        $this->load->model('localisation/language');
        $results = $this->model_localisation_language->getLanguages();
        $languages = [];

        foreach ($results as $result){
            $languages[$result['language_id']] = $result['code'];
        }
        $codes = [];

        foreach ($seo_links as $seo_link){
            $seo_lang_id = $seo_link['language_id'];
            $codes[$languages[$seo_lang_id]][$seo_link['keyword']] = $seo_link['query'];
        }

        $new_url = $url;

        foreach ($url_parts as $url_part){
            if(
                $url_part == '' ||
                $url_part == 'product' ||
                $url_part == 'blog'
            ){
                continue;
            }
            $query_part = $codes[$cur_lang][$url_part];


            foreach ($codes[$target_lang] as $seo_part => $target){
                if($target == $query_part){
                    $new_url = str_replace($url_part, $seo_part, $url);
                }
            }
        }

//        if( $_SERVER['REMOTE_ADDR'] == '5.58.178.186') {
//            echo "<pre style='display: none' id='kl_look_mp'>";
//            print_r([
//                "$cur_lang_href" => $url,
//                "$target_lang_href" => $new_url
//            ]);
//            echo "</pre>";
//        }

        return [
            "$cur_lang_href" => $url,
            "$target_lang_href" => $new_url
        ];


    }

}
