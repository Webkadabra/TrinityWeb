<?php
namespace core\modules\installer\models\setup;

use Yii;
use yii\base\Model;

/**
 * DatabaseForm holds all required database settings.
 *
 * @property string $_name
 * @property string $name
 * @property string $host
 * @property integer $port
 * @property string $database
 * @property string $login
 * @property string $password
 * @property string $table_prefix
 */
class DatabaseForm extends Model
{
    const SCENARIO_ARMORY = 'armory';
    public $_name;

    public $name;
    public $host;
    public $port;
    public $database;
    public $login;
    public $password;
    public $table_prefix;
    
    public function __construct($config = []) {
        $this->setDefault();
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function scenarios() {
        return array_merge(
            parent::scenarios(),
            [
                'armory' => ['host','port','database','login','password','table_prefix']
            ]
        );
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['host', 'port', 'database', 'login'], 'required'],
            [['host', 'database', 'login', 'password', 'table_prefix'],'string'],
            [['port'], 'integer'],
            ['name','safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'host'         => Yii::t('installer','Host'),
            'port'         => Yii::t('installer','Port'),
            'database'     => Yii::t('installer','Name of database'),
            'login'        => Yii::t('installer','Username'),
            'password'     => Yii::t('installer','Password'),
            'table_perfix' => Yii::t('installer','Table prefix')
        ];
    }
    
    protected function setDefault() {
        $this->host = 'localhost';
        $this->port = '3306';
        $this->database = 'trinityweb';
        $this->login = 'root';
    }
}