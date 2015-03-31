<?php

/**
 * Class     Brand_CampaignService
 * 计划信息业务层
 *
 * @author   yangyang3
 */
class Brand_CampaignService extends Base_Brand_Services {

    /**
     * Method  __construct
     * 构造方法
     *
     * @author yangyang3
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Method  getResultByPage
     * 获取分页数据
     *
     * @author yangyang3
     *
     * @param array  $data
     * @param int    $page_size
     * @param int    $page_num
     * @param string $order
     * @param string $desc
     *
     * @return array|bool
     */
    public function getResultByPage(array $data, $page_size, $page_num = 1, $order = null, $desc = 'DESC') {
        if (empty($page_num) || $page_num < 1) {
            $page_num = 1;
        }

        //从campaign表中根据条件获取计划信息
        $brand_campaign_model = new Brand_CampaignModel();

        $campaign_data = $brand_campaign_model->getResultByPage($data, $page_size, $page_num, $order, $desc);

        //查询条件没有数据，直接返回
        if (empty($campaign_data) || empty($campaign_data['data'])) {
            return $campaign_data;
        }

        return $campaign_data;
    }

}