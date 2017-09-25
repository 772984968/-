<?php
use yii\helpers\Html;
?>
<script type="text/javascript" src="/style/js/Area.js"></script>
<script type="text/javascript" src="/style/js/AreaData_min.js"></script>
        <div class="collapse">
              <div class="panel active">
                <div class="panel-head"><h4><?= $other['formname'] ?></h4></div>
                <div class="panel-body">
                
                <?php foreach($data as $v): ?>
                        <?= $v['form'] ?>
                <?php endforeach; ?>
        
                </div>
              </div>
        </div>


<script>
    Do.ready('base', function () {
        $('#form').duxFormPage();
    
    });
</script>

