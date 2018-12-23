<?php
/**
 * This view is used by console/controllers/MigrateController.php
 * The following variables are available in this view:
 */

/* @var $className string the new migration class name */

echo "<?php\n";
?>

use yii\db\Schema;
use core\rbac\Migration;

class <?php echo $className; ?> extends Migration
{
public function up()
{

}

public function down()
{
echo "<?php echo $className; ?> cannot be reverted.\n";

return false;
}
}
