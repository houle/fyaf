<?php

/**
 * Class     CampaignModel
 * 计划信息模型层
 *
 * @author   yangyang3
 */
class Brand_CampaignModel extends Base_Brand_Models {

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
     * @param array  $condition
     * @param int    $page_size
     * @param int    $page_num
     * @param string $order
     * @param string $desc
     *
     * @return array|bool
     */
    public function getResultByPage(array $condition, $page_size = 15, $page_num = 1, $order = null, $desc = 'DESC') {
        $offset = ((int)$page_num - 1) * (int)$page_size;

        if ($offset < 0) {
            $offset = 0;
        }

        $select = $this->select();

        $count_condition = array();

        //验证计划ID
        if (isset($condition['campaign_id'])) {
            $select->where('`ad_id` = ?', $condition['campaign_id']);
            $count_condition['`ad_id` = ?'] = $condition['campaign_id'];
        } else {
            $select->where('`ad_id` > ?', 0);
            $count_condition['`ad_id` > ?'] = 0;
        }

        //验证合同号
        if (isset($condition['contract_no'])) {
            $select->where('`contract_no` = ?', $condition['contract_no']);
            $count_condition['`contract_no` = ?'] = $condition['contract_no'];
        } else {
            $select->where('`contract_no` <> ?', '');
            $count_condition['`contract_no` <> ?'] = '';
        }

        //验证计划名称
        if (isset($condition['campaign_name'])) {
            $select->where('`campaign_name` LIKE ?', "%{$condition['campaign_name']}%");
            $count_condition['`campaign_name` LIKE ?'] = "%{$condition['campaign_name']}%";
        }

        //验证客户ID
        if (isset($condition['customer_id'])) {
            $select->where('`customer_id` = ?', $condition['customer_id']);
            $count_condition['`customer_id` = ?'] = $condition['customer_id'];
        }

        //验证客户昵称
        if (isset($condition['customer_name'])) {
            $select->where('`customer_name` LIKE ?', "%{$condition['customer_name']}%");
            $count_condition['`customer_name` LIKE ?'] = "%{$condition['customer_name']}%";
        }

        //验证广告位置
        if (isset($condition['pdps'])) {
            $select->where('`pdps` = ?', $condition['pdps']);
            $count_condition['`pdps` = ?'] = $condition['pdps'];
        }

        //获取总的数据量
        $total_count = $this->getCount($count_condition);

        if (false === $total_count) {
            return false;
        }

        if (0 === $total_count) {
            return array(
                'total_count'  => $total_count,
                'current_page' => (int)$page_num,
                'offset'       => $offset,
                'limit'        => (int)$page_size,
                'data'         => array()
            );
        }

        if (null !== $page_num && null !== $page_size) {
            if ($offset >= ($total_count)) {
                if ($total_count % $page_size) {
                    $offset = $total_count - ($total_count % $page_size);
                } else {
                    $offset = $total_count - $page_size;
                }

                $page_num = ($offset / $page_size) + 1;
            }

            $select->limit($page_size, $offset);
        }

        if (null !== $order) {
            $select->order($order . ' ' . $desc);
        }

        $data = $this->fetchAll($select);

        if (false !== $data) {
            return array(
                'total_count'  => $total_count,
                'current_page' => (int)$page_num,
                'offset'       => $offset,
                'limit'        => (int)$page_size,
                'data'         => $data
            );
        } else {
            return false;
        }
    }

    /**
     * Method  getInfoByAdId
     * 根据计划ID获取计划信息
     *
     * @author wenjun5
     *
     * @param int $ad_id
     *
     * @return array|bool|mixed|null
     */
    public function getInfoByAdId($ad_id) {
        $count = $this->getCount(array('`ad_id` = ?' => (int)$ad_id));

        if (false === $count) {
            return false;
        }

        if (0 === $count) {
            return null;
        }

        $select = $this->select()->where('`ad_id` = ?', (int)$ad_id);

        return $this->fetchRow($select);
    }

    /**
     * Method  getListByAdIdList
     * 根据计划ID列表获取计划列表
     *
     * @author wenjun5
     *
     * @param array $ad_id_list
     *
     * @return array
     */
    public function getListByAdIdList(array $ad_id_list) {
        if (empty($ad_id_list)) {
            return array();
        }

        $select = $this->select()->where('`ad_id` IN (?)', $ad_id_list)->order('ad_id ASC');

        return $this->fetchAll($select);
    }

    /**
     * Method  updateAdStatusByAdId
     * 根据计划ID更新计划状态
     *
     * @author yangyang3
     *
     * @param int $ad_id
     * @param int $ad_status
     * @param int $pause_status
     *
     * @return bool
     */
    public function updateAdStatusByAdId($ad_id, $ad_status, $pause_status = null) {
        if (Type_Campaign::get($ad_status) === false) {
            return false;
        }

        $where = array(
            '`ad_id` = ?' => (int)$ad_id
        );

        $data = array(
            'ad_status' => (int)$ad_status
        );

        if (null !== $pause_status) {
            $data['pause_status'] = (int)$pause_status;
        }

        $affected_rows = $this->where($where)->update($data);

        if ($affected_rows === false) {
            return false;
        }

        return true;
    }

    /**
     * Method  updateAdStatusByAdIdList
     * 根据计划ID列表更新计划状态
     *
     * @author yangyang3
     *
     * @param array $ad_id_list
     * @param int   $ad_status
     * @param int   $pause_status
     *
     * @return bool
     */
    public function updateAdStatusByAdIdList(array $ad_id_list, $ad_status, $pause_status = null) {
        if (empty($ad_id_list)) {
            return array();
        }

        if (Type_Campaign::get($ad_status) === false) {
            return false;
        }

        $where = array(
            '`ad_id` IN (?)' => $ad_id_list
        );

        $data = array(
            'ad_status' => (int)$ad_status
        );

        if (null !== $pause_status) {
            $data['pause_status'] = (int)$pause_status;
        }

        $affected_rows = $this->where($where)->update($data);

        if ($affected_rows === false) {
            return false;
        }

        return true;
    }

    /**
     * Method  getListByAdStatus
     * 根据状态获取计划列表
     *
     * @author yangyang3
     *
     * @param int $ad_status
     *
     * @return array|bool
     */
    public function getListByAdStatus($ad_status) {
        if (Type_Campaign::get($ad_status) === false) {
            return false;
        }

        $select = $this->select()->where('`ad_id` > ?', 0)->where('`ad_status` = ?', $ad_status);

        return $this->fetchAll($select);
    }

    /**
     * Method  getListByContractNoAndAdStatusList
     * 根据合同号和计划状态列表获取计划列表
     *
     * @author wenjun5
     *
     * @param string $contract_no
     * @param array  $ad_status_list
     *
     * @return array
     */
    public function getListByContractNoAndAdStatusList($contract_no, array $ad_status_list) {
        if (empty($ad_status_list)) {
            return false;
        }

        $select = $this->select()->where('`contract_no` = ?', $contract_no)
            ->where('`ad_status` IN (?)', $ad_status_list);

        return $this->fetchAll($select);
    }


    /**
     * Method  create
     * 创建计划
     *
     * @author yangyang3
     *
     * @param array $data
     *
     * @return bool|int
     */
    public function create(array $data) {
        if (empty($data)) {
            return false;
        }

        $data['insert_time'] = Yaf_Registry::get('request_datetime');

        $insert_id = $this->insert($data);

        return $insert_id;
    }

    /**
     * Method  modify
     * 修改计划
     *
     * @author yangyang3
     *
     * @param array $data
     * @param array $where
     *
     * @return bool
     */
    public function modify(array $data, array $where) {
        if (empty($data) || empty($where)) {
            return false;
        }

        $data['update_time'] = Yaf_Registry::get('request_datetime');

        $affected_rows = $this->where($where)->update($data);

        if ($affected_rows === false) {
            return false;
        }

        return true;
    }

}