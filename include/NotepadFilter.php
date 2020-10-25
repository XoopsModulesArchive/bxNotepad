<?php

/**
 * @brief   一覧フィルタ
 * @version $Id: NotepadFilter.php,v 1.1 2006/02/22 15:35:02 mikhail Exp $
 */
require_once 'exForm/Filter.php';

class GuestNotepadFilter extends exAbstractFilterForm
{
    public $uid_ = 0;

    public $fid_ = 0;

    public function fetch()
    {
        $this->fid_ = $this->getPositiveIntger('fid');
    }

    public function getCriteria($start = 0, $limit = 0, $sort = 0)
    {
        $criteria = $this->getDefaultCriteria($start, $limit);

        $criteria->add(new Criteria('public', 1));

        if ($this->fid_) {
            $criteria->add(new Criteria('fid', $this->fid_));
        }

        return $criteria;
    }

    public function getDefaultCriteria($start = 0, $limit = 0)
    {
        $criteria = new CriteriaCompo();

        $criteria->setSort('update_date');

        $criteria->setOrder('DESC');

        return $criteria;
    }

    public function getExtra()
    {
        $ret = [];

        $ret['fid'] = $this->fid_;

        return $ret;
    }
}

class UserNotepadFilter extends GuestNotepadFilter
{
    public function fetch()
    {
        global $xoopsUser;

        parent::fetch();

        $this->uid_ = $xoopsUser->uid();
    }

    public function getCriteria($start = 0, $limit = 0, $sort = 0)
    {
        $criteria = $this->getDefaultCriteria($start, $limit);

        $criteria->add(new Criteria('uid', $this->uid_));

        $criteria->add(new Criteria('fid', $this->fid_));

        return $criteria;
    }
}
