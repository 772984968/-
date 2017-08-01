<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$userid = \Yii::$app->request->get('userid');
$token = \Yii::$app->request->get('token');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <meta charset="UTF-8">
    <title>成员管理</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<table>
    <tr><td>1</td><td><a href="#id1">创建COS</a></td></tr>
    <tr><td>2</td><td><a href="#id2">修改COS</a></td></tr>
    <tr><td>3</td><td><a href="#id3">添加标签</a></td></tr>
    <tr><td>4</td><td><a href="#id4">创建身份</a></td></tr>
    <tr><td>5</td><td><a href="#id5">更新身份</a></td></tr>
    <tr><td>6</td><td><a href="#id6">创建COS</a></td></tr>
    <tr><td>7</td><td><a href="#id7">发送验证码</a></td></tr>
    <tr><td>8</td><td><a href="#id8">注册</a></td></tr>
    <tr><td>9</td><td><a href="#id9">登入</a></td></tr>
    <tr><td>10</td><td><a href="#id10">上传单图</a></td></tr>
    <tr><td>12</td><td><a href="#id12">删除作品</a></td></tr>
    <tr><td>13</td><td><a href="#id13">作品点赞</a></td></tr>
    <tr><td>14</td><td><a href="#id14">添加评论</a></td></tr>
    <tr><td>15</td><td><a href="#id15">删除评论</a></td></tr>
    <tr><td>16</td><td><a href="#id16"> 添加子评论</a></td></tr>
    <tr><td>17</td><td><a href="#id17">删除子评论</a></td></tr>
    <tr><td>18</td><td><a href="#id18">给评论点赞</a></td></tr>
    <tr><td></td><td><a href="javascript:;">取用户信息： /user/information?id=x</a></td></tr>
    <tr><td>19</td><td><a href="#id19">设置用户信息</a></td></tr>
    <tr><td>20</td><td><a href="#id20">修改密码（通过老密码）</a></td></tr>
    <tr><td>21</td><td><a href="#id21">给身份评论</a></td></tr>
    <tr><td>22</td><td><a href="#id22">给身份评论点赞</a></td></tr>
    <tr><td>23</td><td><a href="#id23">给身份点赞</a></td></tr>
    <tr><td>24</td><td><a href="#id24">删除身份</a></td></tr>
    <tr><td>25</td><td><a href="#id25">找回密码验证码</a></td></tr>
    <tr><td>26</td><td><a href="#id26">找回密码修改</a></td></tr>
    <tr><td>27</td><td><a href="#id27">删除多个作品</a></td></tr>
    <tr><td>28</td><td><a href="#id28">删除多个身份</a></td></tr>
    <tr><td>29</td><td><a href="#id29">上传对象字符串，转成json字符串</a></td></tr>
    <tr><td>30</td><td><a href="#id30">发布圈子话题</a></td></tr>
    <tr><td>31</td><td><a href="#id31">修改圈子话题</a></td></tr>
    <tr><td>32</td><td><a href="#id32">删除圈子话题</a></td></tr>




</table>
   <br />------------------------------------------------------------------------------------<br />


       <div class="container" id="id1">
           创建COS
           <div></div>
           <div class="upload">
               <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/product/add?userid=$userid&token=$token"]) ?>

               title:<input type="text" name="ProductForm[title]" /> <br />
               type:<input type="text" name="ProductForm[type]" /> <br />
               source:<input type="text" name="ProductForm[source]" /> <br />
               coser:<input type="text" name="ProductForm[coser]" /> <br />
               content:<input type="text" name="ProductForm[content]" /> <br />
               images:<input type="text" name="ProductForm[images]" /> <br />
               unauthorized_transmit:<input type="text" name="ProductForm[unauthorized_transmit]" /> <br />
               unauthorized_modify:<input type="text" name="ProductForm[unauthorized_modify]" /> <br />
               status:<input type="text" name="ProductForm[status]" /> <br />
               label:<input type="text" name="ProductForm[label]" /> <br />
               classify:<input type="text" name="ProductForm[classify]" /> <br />

               <input type="submit" value="提交" />
               <?php ActiveForm::end() ?>

           </div>
       </div>

<br />------------------------------------------------------------------------------------<br />


<div class="container" id="id1">
    创建舞蹈
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/product/addvideo?userid=$userid&token=$token"]) ?>

        title:<input type="text" name="ProductForm[title]" /> <br />
        content:<input type="text" name="ProductForm[content]" /> <br />
        images:<input type="text" name="ProductForm[images]" /> <br />
        label:<input type="text" name="ProductForm[label]" /> <br />
        classify:<input type="text" name="ProductForm[classify]" /> <br />
        video:<input type="text" name="ProductForm[video]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>

    </div>
</div>


   <br />------------------------------------------------------------------------------------<br />

   <div class="container" id="id2">
       修改COS
       <div></div>
       <div class="upload">
           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/product/update?userid=$userid&token=$token"]) ?>
           id:<input type="text" name="ProductForm[id]" /> <br />
           title:<input type="text" name="ProductForm[title]" /> <br />
           type:<input type="text" name="ProductForm[type]" /> <br />
           source:<input type="text" name="ProductForm[source]" /> <br />
           coser:<input type="text" name="ProductForm[coser]" /> <br />
           content:<input type="text" name="ProductForm[content]" /> <br />
           images:<input type="text" name="ProductForm[images]" /> <br />
           unauthorized_transmit:<input type="text" name="ProductForm[unauthorized_transmit]" /> <br />
           unauthorized_modify:<input type="text" name="ProductForm[unauthorized_modify]" /> <br />
           status:<input type="text" name="ProductForm[status]" /> <br />
           label:<input type="text" name="ProductForm[label]" /> <br />
           classify:<input type="text" name="ProductForm[classify]" /> <br />

           <input type="submit" value="提交" />
           <?php ActiveForm::end() ?>

       </div>
   </div>

   <br />------------------------------------------------------------------------------------<br />
   <div class="container" id="id3">
       添加标签
       <div></div>
       <div class="upload">
           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/label/add?userid=$userid&token=$token"]) ?>
           name:<input type="text" name="LabelForm[name]" /> <br />
           <input type="submit" value="提交" />
           <?php ActiveForm::end() ?>
       </div>
   </div>


   <br />------------------------------------------------------------------------------------<br />

   <div class="container" id="id4">
       创建身份
       <div></div>
       <div class="upload">
           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/status/add?userid=$userid&token=$token"]) ?>
               预约模式:<input type="text" name="StatusForm[beforehand_model]" /> <br />
               开始时间:<input type="text" name="StatusForm[start_dt]" /> <br />
            结束时间:<input type="text" name="StatusForm[end_dt]" /> <br />
           详细地址:<input type="text" name="StatusForm[address]" /> <br />
           金额:<input type="text" name="StatusForm[money]" /> <br />
               省:<input type="text" name="StatusForm[province]" /> <br />
           市:<input type="text" name="StatusForm[city]" /> <br />
           区:<input type="text" name="StatusForm[county]" /> <br />
                身份:<input type="text" name="StatusForm[status]" /> <br />
               内容:<input type="text" name="StatusForm[content]" /> <br />
               图片:<input type="text" name="StatusForm[images]" /> <br />
           <input type="submit" value="提交" />
           <?php ActiveForm::end() ?>

       </div>
   </div>

   <br />------------------------------------------------------------------------------------<br />

   <div class="container" id="id5">
       更新身份
       <div></div>
       <div class="upload">
           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/status/update?userid=$userid&token=$token"]) ?>
           ID:<input type="text" name="StatusForm[id]" /> <br />
           预约模式:<input type="text" name="StatusForm[beforehand_model]" /> <br />
           开始时间:<input type="text" name="StatusForm[start_dt]" /> <br />
           结束时间:<input type="text" name="StatusForm[end_dt]" /> <br />
           详细地址:<input type="text" name="StatusForm[address]" /> <br />
           金额:<input type="text" name="StatusForm[money]" /> <br />
           省:<input type="text" name="StatusForm[province]" /> <br />
           市:<input type="text" name="StatusForm[city]" /> <br />
           区:<input type="text" name="StatusForm[county]" /> <br />
           身份:<input type="text" name="StatusForm[status]" /> <br />
           内容:<input type="text" name="StatusForm[content]" /> <br />
           图片:<input type="text" name="StatusForm[images]" /> <br />
           <input type="submit" value="提交" />
           <?php ActiveForm::end() ?>

       </div>
   </div>



   <br />------------------------------------------------------------------------------------<br />

   <div class="container" id="id6">
       创建COS
       <div></div>
       <div class="upload">
           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>'/image/products?userid='.$userid.'&token='.$token]) ?>
           images:<input id="uploadform-file" name="UploadImagesForm[file][]" multiple=""  type="file"> <br />

           <input type="submit" value="提交" />
           <?php ActiveForm::end() ?>
       </div>
   </div>


   <br />------------------------------------------------------------------------------------<br />

   <div class="container" id="id7">
       发送验证码
       <div></div>
       <div class="upload">
           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/register/code?userid=$userid&token=$token"]) ?>
           账号:<input type="text" name="name" /> <br />

           <input type="submit" value="提交" />
           <?php ActiveForm::end() ?>

       </div>
    </div>
   <br />------------------------------------------------------------------------------------<br />

   <div class="container" id="id8">
       注册
       <div></div>
       <div class="upload">
           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/register/register?userid=$userid&token=$token"]) ?>
           账号:<input type="text" name="RegisterForm[name]" /> <br />
           密码:<input type="text" name="RegisterForm[password]" /> <br />
           验证码:<input type="text" name="RegisterForm[code]" /> <br />
           <input type="submit" value="提交" />
           <?php ActiveForm::end() ?>

       </div>
   </div>

   <br />------------------------------------------------------------------------------------<br />

   <div class="container" id="id9">
       登入
       <div></div>
       <div class="upload">
           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>'/login/login']) ?>
           账号:<input type="text" name="LoginForm[name]" /> <br />
           密码:<input type="text" name="LoginForm[password]" /> <br />
           <input type="submit" value="提交" />
           <?php ActiveForm::end() ?>

       </div>
   </div>

   <br />------------------------------------------------------------------------------------<br />

   <div class="container" id="id10">
       上传文件
       <div></div>
       <div class="upload">
           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>'/upload/file?userid='. $userid .'&token='.$token]) ?>
           文件:<input type="file" name="UploadForm[file]" /> <br />
           <input type="submit" value="提交" />
           <?php ActiveForm::end() ?>

       </div>
   </div>

   <br />------------------------------------------------------------------------------------<br />

   <div class="container" id="id12">
       删除作品
       <div></div>
       <div class="upload">
           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/product/del?userid=$userid&token=$token"]) ?>
           作品ID:<input type="text" name="ProductForm[id]" /> <br />
           <input type="submit" value="提交" />
           <?php ActiveForm::end() ?>
       </div>
   </div>

   <br />------------------------------------------------------------------------------------<br />

   <div class="container" id="id13">
       作品点赞
       <div></div>
       <div class="upload">
           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/product/praise?userid=$userid&token=$token"]) ?>
           作品ID:<input type="text" name="ProductForm[id]" /> <br />
           <input type="submit" value="提交" />
           <?php ActiveForm::end() ?>
       </div>
   </div>

   <br />------------------------------------------------------------------------------------<br />

   <div class="container" id="id14">
       添加评论
       <div></div>
       <div class="upload">
           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/product/commentadd?userid=$userid&token=$token"]) ?>
           作品ID:<input type="text" name="CommentForm[object_id]" /> <br />
           内容:<input type="text" name="CommentForm[content]" /> <br />
           <input type="submit" value="提交" />
           <?php ActiveForm::end() ?>
       </div>
   </div>

   <br />------------------------------------------------------------------------------------<br />

   <div class="container" id="id15">
       删除评论
       <div></div>
       <div class="upload">
           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/product/commentdel?userid=$userid&token=$token"]) ?>
           评论ID:<input type="text" name="CommentForm[id]" /> <br />
           <input type="submit" value="提交" />
           <?php ActiveForm::end() ?>
       </div>
   </div>

   <br />------------------------------------------------------------------------------------<br />

   <div class="container" id="id16">
       添加子评论
       <div></div>
       <div class="upload">
           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/product/commentaddson?userid=$userid&token=$token"]) ?>
           作品ID:<input type="text" name="CommentForm[object_id]" /> <br />
           评价ID:<input type="text" name="CommentForm[comment_id]" /> <br />
           内容:<input type="text" name="CommentForm[content]" /> <br />
           接收者:<input type="text" name="CommentForm[receiver_id]" /> <br />
           <input type="submit" value="提交" />
           <?php ActiveForm::end() ?>
       </div>
   </div>

   <br />------------------------------------------------------------------------------------<br />

   <div class="container" id="id17">
       删除子评论
       <div></div>
       <div class="upload">
           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/product/commentdelson?userid=$userid&token=$token"]) ?>
           评论ID:<input type="text" name="CommentForm[id]" /> <br />
           <input type="submit" value="提交" />
           <?php ActiveForm::end() ?>
       </div>
   </div>

   <br />------------------------------------------------------------------------------------<br />

   <div class="container" id="id18">
       给评论点赞
       <div></div>
       <div class="upload">
           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/product/commentpraise?userid=$userid&token=$token"]) ?>
           作品ID:<input type="text" name="CommentForm[object_id]" /> <br />
           评论ID:<input type="text" name="CommentForm[comment_id]" /> <br />
           <input type="submit" value="提交" />
           <?php ActiveForm::end() ?>
       </div>
   </div>

    <br />------------------------------------------------------------------------------------<br />

    <div class="container" id="id19">
        设置
        <div></div>
        <div class="upload">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/user/setinformation?userid=$userid&token=$token"]) ?>
            icon:<input type="text" name="UserForm[icon]" /> <br />
            nickname:<input type="text" name="UserForm[nickname]" /> <br />
            sex:<input type="text" name="UserForm[sex]" /> <br />
            site:<input type="text" name="UserForm[site]" /> <br />
            intro:<input type="text" name="UserForm[intro]" /> <br />
            height:<input type="text" name="UserForm[height]" /> <br />
            weight:<input type="text" name="UserForm[weight]" /> <br />

            <input type="submit" value="提交" />
            <?php ActiveForm::end() ?>
        </div>
    </div>

<br />------------------------------------------------------------------------------------<br />

    <div class="container" id="id20">
    修改密码
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/user/changepass?userid=$userid&token=$token"]) ?>
        old:<input type="text" name="ChangePassForm[old]" /> <br />
        new:<input type="text" name="ChangePassForm[new]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>


<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id21">
    给身份评论
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/status/commentadd?userid=$userid&token=$token"]) ?>
        身份ID:<input type="text" name="CommentForm[object_id]" /> <br />
        内容:<input type="text" name="CommentForm[content]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>
<br />------------------------------------------------------------------------------------<br />

<div class="container" id="">
    删除身份评论
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/status/commentdel?userid=$userid&token=$token"]) ?>
        评论ID:<input type="text" name="CommentForm[id]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id22">
    给身份评论点赞
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/status/commentpraise?userid=$userid&token=$token"]) ?>
        身份ID:<input type="text" name="CommentForm[object_id]" /> <br />
        评论ID:<input type="text" name="CommentForm[comment_id]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>


<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id23">
    给身份点赞
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/status/praise?userid=$userid&token=$token"]) ?>
        身份ID:<input type="text" name="StatusForm[id]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>
<br />------------------------------------------------------------------------------------<br />
<div class="container" id="id24">
    删除身份
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/status/del?userid=$userid&token=$token"]) ?>
        身份ID:<input type="text" name="StatusForm[id]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />
<div class="container" id="id25">
    找回密码，短信验证码
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/findpassword/code?userid=$userid&token=$token"]) ?>
        帐号:<input type="text" name="name" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />
<div class="container" id="id26">
    找回密码修改密码
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/findpassword/findpassword?userid=$userid&token=$token"]) ?>
        帐号:<input type="text" name="FindPasswordForm[name]" /> <br />
        密码:<input type="text" name="FindPasswordForm[password]" /> <br />
        验证码:<input type="text" name="FindPasswordForm[code]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />
<div class="container" id="id27">
    删除多个作品
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/product/dels?userid=$userid&token=$token"]) ?>
        作品ID:<input type="text" name="id" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />
<div class="container" id="id28">
    删除多个身份
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/status/dels?userid=$userid&token=$token"]) ?>
        身份ID:<input type="text" name="id" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />
<div class="container" id="id29">
    上传对象字符串，转成json字符串
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/test/objtojson?userid=$userid&token=$token"]) ?>
        text:<textarea rows="10" cols="100" name="text"></textarea>
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id30">
    发布圈子话题
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/circle/add?userid=$userid&token=$token"]) ?>
        title:<input type="text" name="CircleForm[title]" /> <br />
        content:<input type="text" name="CircleForm[content]" /> <br />
        images:<input type="text" name="CircleForm[images]" /> <br />
        label:<input type="text" name="CircleForm[label]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id30">
    修改圈子话题
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/circle/update?userid=$userid&token=$token"]) ?>
        id:<input type="text" name="CircleForm[id]" /> <br />
        title:<input type="text" name="CircleForm[title]" /> <br />
        content:<input type="text" name="CircleForm[content]" /> <br />
        images:<input type="text" name="CircleForm[images]" /> <br />
        label:<input type="text" name="CircleForm[label]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id30">
    删除圈子话题
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/circle/del?userid=$userid&token=$token"]) ?>
        id:<input type="text" name="CircleForm[id]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>


<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id31">
    圈子话题添加评论
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/circle/commentadd?userid=$userid&token=$token"]) ?>
        作品ID:<input type="text" name="CommentForm[object_id]" /> <br />
        内容:<input type="text" name="CommentForm[content]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id32">
    圈子话题删除评论
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/circle/commentdel?userid=$userid&token=$token"]) ?>
        评论ID:<input type="text" name="CommentForm[id]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id33">
    圈子话题添加子评论
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/circle/commentaddson?userid=$userid&token=$token"]) ?>
        作品ID:<input type="text" name="CommentForm[object_id]" /> <br />
        评价ID:<input type="text" name="CommentForm[comment_id]" /> <br />
        内容:<input type="text" name="CommentForm[content]" /> <br />
        接收者:<input type="text" name="CommentForm[receiver_id]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id34">
    圈子话题删除子评论
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/circle/commentdelson?userid=$userid&token=$token"]) ?>
        评论ID:<input type="text" name="CommentForm[id]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id35">
    关注人
    <div></div>
    <div class="upload">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/user/concern?userid=$userid&token=$token"]) ?>
        关注ID:<input type="text" name="ConcernForm[target]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>


<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id36">
    关注圈子
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/circle/concern?userid=$userid&token=$token"]) ?>
        关注ID:<input type="text" name="ConcernForm[target]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id31">
    推荐文章添加评论
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/recommend/commentadd?userid=$userid&token=$token"]) ?>
        文章ID:<input type="text" name="CommentForm[object_id]" /> <br />
        内容:<input type="text" name="CommentForm[content]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id32">
    推荐文章删除评论
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/recommend/commentdel?userid=$userid&token=$token"]) ?>
        文章ID:<input type="text" name="CommentForm[id]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id33">
    推荐文章添加子评论
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/recommend/commentaddson?userid=$userid&token=$token"]) ?>
        文章ID:<input type="text" name="CommentForm[object_id]" /> <br />
        评价ID:<input type="text" name="CommentForm[comment_id]" /> <br />
        内容:<input type="text" name="CommentForm[content]" /> <br />
        接收者:<input type="text" name="CommentForm[receiver_id]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id34">
    推荐文章删除子评论
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/recommend/commentdelson?userid=$userid&token=$token"]) ?>
        评论ID:<input type="text" name="CommentForm[id]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

</body>
</html>
