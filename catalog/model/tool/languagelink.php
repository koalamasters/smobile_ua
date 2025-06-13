<?php

class ModelToolLanguagelink extends Model
{
    public function getSeoLinks()
    {

        $sql = "SELECT language_id, query, keyword FROM `oc_seo_url`;";
        $query = $this->db->query($sql);
        return $query->rows;
    }
}