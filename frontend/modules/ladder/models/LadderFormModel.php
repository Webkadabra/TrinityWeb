<?php

namespace frontend\modules\ladder\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\models\chars\ArenaTeam;
use core\models\chars\ArenaTeamMember;

/**
 * LadderFormModel
 */
class LadderFormModel extends Model
{
    public $server = null;
    public $type = null;

    public $_arr_types = [
        2 => '2x2',
        3 => '3x3',
        5 => '5x5'
    ];

    const TYPE_2 = 2;// 2vs2
    const TYPE_3 = 3;// 3vs3
    const TYPE_5 = 5;// 5vs5 / soloq

    /**
     * LadderFormModel constructor.
     * @param array $config
     * @throws \yii\base\Exception
     */
    public function __construct($config = array()) {
        parent::__construct($config);
        $this->server = Yii::$app->DBHelper->getServerName();
        $this->type = $this->_arr_types[2];
    }

    public function formName() {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['server', 'type'], 'required'],
            [['type'], 'integer'],
            [['server'], 'trim'],
            [['server'], 'string'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'server' => Yii::t('ladder', 'Игровой мир'),
            'type' => Yii::t('ladder', 'Тип')
        ];
    }

    public function search($params) {
        $query = ArenaTeam::find()->orderBy(['rating' => SORT_DESC])->with(['members.character'])->asArray();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->settings->get(Yii::$app->settings::APP_MODULE_LADDER_PER_PAGE),
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'type' => $this->type
        ]);

        return $dataProvider;
    }

    public function getServers() {
        $servers = Yii::$app->DBHelper->getServers(true);
        $data = [];
        foreach($servers as $server) {
            $data[$server] = $server;
        }
        return $data;
    }

}