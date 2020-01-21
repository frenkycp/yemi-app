<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "dbo.VIEW_YEMI_Emp_OrgUnit".
 *
 * @property string $Emp_no
 * @property string $Full_name
 * @property string $grade_code
 * @property string $start_date
 * @property integer $position_id
 * @property integer $dept_id
 * @property string $pos_name_en
 * @property string $pos_code
 * @property string $parent_path
 * @property string $BOD
 * @property string $Division
 * @property string $Department
 * @property string $Section
 * @property string $Group
 * @property string $Sub-Group
 * @property integer $status
 * @property string $employ_code
 * @property string $photo
 * @property string $gender
 * @property string $birthplace
 * @property string $birthdate
 * @property string $address
 * @property string $phone
 * @property string $identity_no
 * @property string $taxfilenumber
 * @property string $JP
 * @property string $BPJS
 * @property string $cost_center
 * @property string $gradecategory_name
 * @property string $aliasModel
 */
abstract class SunfishViewEmp extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dbo.VIEW_YEMI_Emp_OrgUnit';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_sun_fish');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Emp_no', 'grade_code', 'start_date', 'position_id', 'dept_id', 'pos_name_en', 'pos_code', 'parent_path', 'status', 'employ_code', 'cost_center'], 'required'],
            [['Emp_no', 'Full_name', 'grade_code', 'pos_name_en', 'pos_code', 'parent_path', 'BOD', 'Division', 'Department', 'Section', 'Group', 'Sub-Group', 'employ_code', 'photo', 'gender', 'birthplace', 'address', 'phone', 'identity_no', 'taxfilenumber', 'JP', 'BPJS', 'cost_center', 'gradecategory_name'], 'string'],
            [['start_date', 'birthdate'], 'safe'],
            [['position_id', 'dept_id', 'status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Emp_no' => 'Emp No',
            'Full_name' => 'Full Name',
            'grade_code' => 'Grade Code',
            'start_date' => 'Start Date',
            'position_id' => 'Position ID',
            'dept_id' => 'Dept ID',
            'pos_name_en' => 'Pos Name En',
            'pos_code' => 'Pos Code',
            'parent_path' => 'Parent Path',
            'BOD' => 'Bod',
            'Division' => 'Division',
            'Department' => 'Department',
            'Section' => 'Section',
            'Group' => 'Group',
            'Sub-Group' => 'Sub  Group',
            'status' => 'Status',
            'employ_code' => 'Employ Code',
            'photo' => 'Photo',
            'gender' => 'Gender',
            'birthplace' => 'Birthplace',
            'birthdate' => 'Birthdate',
            'address' => 'Address',
            'phone' => 'Phone',
            'identity_no' => 'Identity No',
            'taxfilenumber' => 'Taxfilenumber',
            'JP' => 'Jp',
            'BPJS' => 'Bpjs',
            'cost_center' => 'Cost Center',
            'gradecategory_name' => 'Gradecategory Name',
        ];
    }




}
