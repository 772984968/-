<?php
    }

    /**
     *
     * @author li
     *         邀请账号列表
     */
    public function actionInvitations()
    {
            'and'
        ];
        if ($this->isPost()) {
            $data = Yii::$app->getRequest()->post();
            if (! empty(($data['search']['stime']))) {
                $stime = $data['search']['stime'];
                array_push($where, [
                    '>=',
                    'created_at',
                    $stime
                ]);
                $searchvalue['stime'] = $stime;
            }
            if (! empty(($data['search']['etime']))) {

                $etime = $data['search']['etime'];
                array_push($where, [
                    '<=',
                    'created_at',
                    $etime
                ]);
                $searchvalue['etime'] = $etime;
            }

            if ($data['search']['vip_type'] != '') {
                $vip_type = $data['search']['vip_type'];
                array_push($where, [
                    '=',
                    'vip_type',
                    $vip_type
                ]);
                $searchvalue['vip_type'] = $vip_type;
            }

            $this->data['searchvalue'] = $searchvalue;
        }

    //    "select sum(number) as number FROM at_user_diamond_log where userid in(select iid from at_user where incke='jiahua') AND ";

        // 代理级别

        $user = $model::findone($id);
        array_push($where, [
            '=',
            'inviteCode',
            $user->llaccounts
        ]);
        $this->data['invites'] = $invites;
        $this->data['id']=$id;