<?php

/**
 * Class     CampaignController
 * 计划信息控制器
 *
 * @author   luoliang1
 */
class CampaignController extends Base_Brand_Controllers {

    /**
     * Method  init
     * 初始化方法
     *
     * @author luoliang1
     */
    public function init() {
        parent::init();
    }

    /**
     * Method  showAction
     * 获取计划信息
     * @method GET
     *
     * @author luoliang1
     */
    public function showAction() {
        $campaign_id = $this->request->getQuery('campaign_id');

        //获取计划信息
        $brand_campaign_service = new Brand_CampaignService();

        $campaign_info = $brand_campaign_service->getInfoByCampaignId($campaign_id);

        if (false === $campaign_info) {
            $this->error($brand_campaign_service->getErrorCode());
        }

        $this->jsonReturn($campaign_info);
    }


    /**
     * Method  listAction
     * 获取计划列表
     * @method GET
     *
     * @author luoliang1
     */
    public function listAction() {
        $current_page = intval($this->request->getQuery('page'));

        $brand_campaign_service = new Brand_CampaignService();

        $page_size = intval(Yaf_Registry::get('config')->admin->pagination->page_size);

        $page_result = $brand_campaign_service->getResultByPage(array(), $page_size, $current_page, 'ad_id', 'DESC');

        if (false === $page_result) {
            $this->error($brand_campaign_service->getErrorCode());
        }

        $this->jsonReturn($page_result);
    }

    /**
     * Method  searchAction
     * 搜索方法
     * @method GET
     *
     * @author luoliang1
     */
    public function searchAction() {
        //接收各种参数
        $campaign_id   = $this->request->getQuery('campaign_id');
        $campaign_name = $this->request->getQuery('campaign_name');
        $contract_no   = $this->request->getQuery('contract_no');
        $customer_id   = $this->request->getQuery('customer_id');
        $customer_name = $this->request->getQuery('customer_name');
        $pdps          = $this->request->getQuery('pdps');
        $type          = $this->request->getQuery('type');
        $status        = $this->request->getQuery('status');
        $start_time    = $this->request->getQuery('start_time');
        $end_time      = $this->request->getQuery('end_time');
        $current_page  = intval($this->request->getQuery('page'));

        $condition = array();

        //验证计划ID
        if (!empty($campaign_id) && Validator::is_numeric($campaign_id)) {
            $condition['campaign_id'] = intval($campaign_id);
        }

        //校验计划名称
        if (!empty($campaign_name)) {
            $condition['campaign_name'] = $campaign_name;
        }

        //校验合同号
        if (!empty($contract_no)) {
            $condition['contract_no'] = $contract_no;
        }

        //校验用户ID
        if (!empty($customer_id) && Validator::is_numeric($customer_id)) {
            $condition['customer_id'] = intval($customer_id);
        }

        //校验用户名称
        if (!empty($customer_name)) {
            $condition['customer_name'] = $customer_name;
        }

        //校验广告位置
        if (!empty($pdps)) {
            $condition['pdps'] = $pdps;
        }

        //校验计划类型
        if (!empty($type)) {
            $condition['type'] = $type;
        }

        //校验状态
        if (null !== $status && Validator::is_numeric($status) && Type_Brand_Campaign::get($status)) {
            $condition['status'] = intval($status);
        }

        //校验开始投放时间上限
        if (Validator::is_date($start_time)) {
            $condition['start_time'] = date('Y-m-d', $start_time);
        }

        //校验开始投放时间下限
        if (Validator::is_date($end_time)) {
            $condition['end_time'] = date('Y-m-d', $end_time);
        }

        //没有传入任何有效的查询参数
        if (empty($condition)) {
            $condition = array();
        }

        $page_size = intval(Yaf_Registry::get('config')->admin->pagination->page_size);

        $brand_campaign_service = new Brand_CampaignService();

        $page_result = $brand_campaign_service->getResultByPage($condition, $page_size, $current_page, 'ad_id', 'DESC');

        if (false === $page_result) {
            $this->error($brand_campaign_service->getErrorCode());
        }

        $this->jsonReturn($page_result);
    }

    /**
     * Method  createAction
     * 添加操作 /test/campaign/create.json
     * @method POST
     *
     * @author luoliang1
     */
    public function createAction() {
        $data = array(
            'contract_no'           => $this->request->getPost('contract_no'),
            'batch_uid'             => $this->request->getPost('batch_uid'),
            'campaign_form_content' => $this->request->getPost('campaign_form_content'),
        );

        $brand_campaign_service = new Brand_CampaignService();

        $result = $brand_campaign_service->create($data);

        if (false === $result) {
            $this->jsonError($brand_campaign_service->getErrorCode());
        }

        $this->success();
    }

    /**
     * Method  modifyAction
     * 修改操作
     * @method POST
     *
     * @author luoliang1
     */
    public function modifyAction() {
        $data = array(
            'campaign_id'           => $this->request->getPost('campaign_id'),
            'campaign_form_content' => $this->request->getPost('campaign_form_content')
        );

        $brand_campaign_service = new Brand_CampaignService();

        $result = $brand_campaign_service->modify($data);

        if (false === $result) {
            $this->jsonError($brand_campaign_service->getErrorCode());
        }

        $this->success();
    }

    /**
     * Method  startAction
     * 启动操作
     * @method GET
     *
     * @author luoliang1
     */
    public function startAction() {
        $campaign_id = $this->request->getQuery('campaign_id');

        $brand_campaign_service = new Brand_CampaignService();

        $result = $brand_campaign_service->start($campaign_id);

        if (false === $result) {
            $this->error($brand_campaign_service->getErrorCode());
        }

        $this->success();
    }

    /**
     * Method  pauseAction
     * 暂停操作
     * @method GET
     *
     * @author luoliang1
     */
    public function pauseAction() {
        $campaign_id = $this->request->getQuery('campaign_id');

        $brand_campaign_service = new Brand_CampaignService();

        $result = $brand_campaign_service->pause($campaign_id);

        if (false === $result) {
            $this->error($brand_campaign_service->getErrorCode());
        }

        $this->success();
    }

    /**
     * Method  stopAction
     * 终止操作
     * @method GET
     *
     * @author luoliang1
     */
    public function stopAction() {
        $campaign_id = $this->request->getQuery('campaign_id');

        $brand_campaign_service = new Brand_CampaignService();

        $result = $brand_campaign_service->stop($campaign_id);

        if (false === $result) {
            $this->error($brand_campaign_service->getErrorCode());
        }

        $this->success();
    }

}