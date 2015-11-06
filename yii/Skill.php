<?php

/**
 * This is the model class for table "Skill".
 *
 * The followings are the available columns in table 'Skill':
 * @property integer $id
 * @property string $name
 * @property string $begin_of_name
 * @property string $end_of_name
 * @property double $pay_rate
 * @property integer $hide
 */
class Skill extends ActiveRecord
{

    public $pay_rate_contractor_begin = 0;
    public $pay_rate_contractor_end = 0;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Skill the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'skill';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name,pay_rate', 'required'),
            array('name', 'length', 'max' => 60),
            array('begin_of_name, end_of_name', 'length', 'max' => 30),
            array('pay_rate, hide', 'numerical'),
            array('id, name, hide', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'skillMap' => array(self::HAS_MANY, 'SkillMapping', 'skill_id'),
            'course' => array(self::HAS_MANY, 'Course', 'skill_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'name' => Yii::t('skill', 'Skill'),
            'pay_rate' => Yii::t('skill', 'Pay rate'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('pay_rate', $this->pay_rate, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function createLicense($skillMappingId, $image)
    {
        return LicenseMapping::create($skillMappingId, $image);
    }

    public static function toggleMappingStatus($id)
    {
        SkillMapping::toggleStatus($id);
    }

    /**
     * @param null $hide
     * @return self[]
     */
    public static function All($hide = null)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('hide', $hide);

        return self::model()->findAll($criteria);
    }

    public static function deleteMappingById($id)
    {
        $mapping = SkillMapping::model()->findByPk($id);
        if ($mapping) {
            if ($mapping->delete()) {
                return true;
            }
        }

        return false;
    }

    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            list($begin, $end) = explode("-", $this->name);
            $begin = trim($begin);
            $end = trim($end);

            $this->begin_of_name = $begin;
            if (!empty($end)) {
                $this->end_of_name = $end;
            }
            return true;
        }
        return false;
    }

    protected function afterSave()
    {
        $lastPayRateContractor = PayRateContractor::getByAttributes(
            $this->id,
            $this->pay_rate_contractor_begin,
            $this->pay_rate_contractor_end
        );
        if (!$lastPayRateContractor || ($lastPayRateContractor->pay_rate !== $this->pay_rate)) {
            $payRateContractor = new PayRateContractor();
            $payRateContractor->setAttribute('skill_id', $this->id);
            $payRateContractor->setAttribute('date_begin', $this->pay_rate_contractor_begin);
            $payRateContractor->setAttribute('date_end', $this->pay_rate_contractor_end);
            $payRateContractor->setAttribute('pay_rate', number_format($this->pay_rate, 2));

            $status = false;

            $historicalPayRatesContractor = PayRateContractor::getBetweenDate(
                $payRateContractor->skill_id,
                $payRateContractor->date_begin,
                $payRateContractor->date_end
            );

            /**
             * @var $historicalPayRatesContractor PayRateContractor[]
             */
            if (is_array($historicalPayRatesContractor) && count($historicalPayRatesContractor) > 0) {
                foreach ($historicalPayRatesContractor as $single) {
                    if (($single->date_begin <= $payRateContractor->date_end) && ($single->date_end > $payRateContractor->date_end)) {
                        if ($single->pay_rate === $payRateContractor->pay_rate) {
                            $payRateContractor->setAttribute('date_end', $single->date_end);
                            $single->setAttribute('deleted', $payRateContractor::DELETED);
                            $single->save();
                        } else {
                            $single->setAttribute('date_begin', $payRateContractor->date_end + $payRateContractor::ONE_DAY);
                            $single->save();
                        }
                    } elseif (($single->date_begin < $payRateContractor->date_begin) && ($single->date_end >= $payRateContractor->date_begin)) {
                        if ($single->pay_rate === $payRateContractor->pay_rate) {
                            $payRateContractor->setAttribute('date_begin', $single->date_begin);
                            $single->setAttribute('deleted', $payRateContractor::DELETED);
                            $single->save();
                        } else {
                            $single->setAttribute('date_end', $payRateContractor->date_begin - $payRateContractor::ONE_DAY);
                            $single->save();
                        }
                    } else {
                        $single->setAttribute('deleted', $payRateContractor::DELETED);
                        $single->save();
                    }
                }
                $status = true;
                $payRateContractor->save();
            }

            $historicalPayRateContractor = PayRateContractor::getInDate(
                $payRateContractor->skill_id,
                $payRateContractor->date_begin,
                $payRateContractor->date_end
            );

            if ($historicalPayRateContractor) {
                if ($historicalPayRateContractor->pay_rate !== $payRateContractor->pay_rate) {
                    $futurePayRateContractor = new PayRateContractor();
                    $futurePayRateContractor->setAttribute('skill_id', $payRateContractor->skill_id);
                    $futurePayRateContractor->setAttribute('pay_rate', $historicalPayRateContractor->pay_rate);
                    $futurePayRateContractor->setAttribute('date_end', $historicalPayRateContractor->date_end);
                    $futurePayRateContractor->setAttribute('date_begin', $payRateContractor->date_end + $payRateContractor::ONE_DAY);
                    $historicalPayRateContractor->setAttribute('date_end', $payRateContractor->date_begin - $payRateContractor::ONE_DAY);
                    $futurePayRateContractor->save();
                    $historicalPayRateContractor->save();
                    $payRateContractor->save();
                }
                $status = true;
            }

            if (!$status) {
                $firstDate = strtotime('2014-01-20');
                $oldAttributes = $this->getOldAttributes();
                if ($payRateContractor->date_begin !== $payRateContractor->date_end) {
                    if ($this->pay_rate_contractor_begin > $firstDate) {
                        $firstPayRateContractor = new PayRateContractor();
                        $firstPayRateContractor->setAttribute('date_begin', $firstDate);
                        $firstPayRateContractor->setAttribute('date_end', $payRateContractor->date_begin - $payRateContractor::ONE_DAY);
                        $firstPayRateContractor->setAttribute('skill_id', $payRateContractor->skill_id);
                        $firstPayRateContractor->setAttribute('pay_rate', number_format($oldAttributes['pay_rate'], 2));
                        $firstPayRateContractor->save();
                    }
                    if ($this->pay_rate_contractor_end < strtotime(date('Y-m-d'))) {
                        $currentPayRateContractor = new PayRateContractor();
                        $currentPayRateContractor->setAttribute('date_begin', $payRateContractor->date_end + $payRateContractor::ONE_DAY);
                        $currentPayRateContractor->setAttribute('date_end', strtotime(date('Y-m-d')));
                        $currentPayRateContractor->setAttribute('skill_id', $payRateContractor->skill_id);
                        $currentPayRateContractor->setAttribute('pay_rate', number_format($oldAttributes['pay_rate'], 2));
                        $currentPayRateContractor->save();
                    }
                } else {
                    $payRateContractor->setAttribute('date_begin', $firstDate);
                }
                $payRateContractor->save();
            }
        }
    }

    public static function AllBegin()
    {
        $criteria = new CDbCriteria;
        $criteria->group = 't.begin_of_name';
        return self::model()->findAll($criteria);
    }

    public static function getEndOfName($beginOfName)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('begin_of_name', $beginOfName);
        $skills = Skill::model()->findAll($criteria);
        $data = CHtml::listData($skills, 'end_of_name', 'end_of_name');
        return $data;
    }
}