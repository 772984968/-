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
           关闭加密:<input type="text" name="RegisterForm[encryption]" /> <br />
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
           关闭加密:<input type="text" name="LoginForm[encryption]" /> <br />
           <input type="submit" value="提交" />
           <?php ActiveForm::end() ?>

       </div>
   </div>

   <br />------------------------------------------------------------------------------------<br />

   <div class="container" id="id10">
       上传单图
       <div></div>
       <div class="upload">
           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>'/image/product?userid='. $userid .'&token='.$token]) ?>
           文件:<input type="file" name="UploadImageForm[file]" /> <br />
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
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/center/changepass?userid=$userid&token=$token"]) ?>
        old:<input type="text" name="old" /> <br />
        new:<input type="text" name="new" /> <br />
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
        关闭加密:<input type="text" name="FindPasswordForm[encryption]" /> <br />
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

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id35">
    创建订单
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/orders/create?userid=$userid&token=$token"]) ?>
        product_id:<input type="text" name="OrderForm[product_id]" /> <br />
        product_type:<input type="text" name="OrderForm[product_type]" /> <br />
        数量:<input type="text" name="OrderForm[number]" /> <br />
        地址:<input type="text" name="OrderForm[address]" /> <br />
        开始时间 :<input type="text" name="OrderForm[start_dt]" /> <br />
        结束时间:<input type="text" name="OrderForm[end_dt]" /> <br />
        商家留言:<input type="text" name="OrderForm[message]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id36">
    开始订单
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/orders/start?userid=$userid&token=$token"]) ?>
        订单ID:<input type="text" name="order_id" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id37">
    确认订单
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/orders/accomplish?userid=$userid&token=$token"]) ?>
        订单ID:<input type="text" name="order_id" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id38">
    取登入短信验证码
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/login/code?userid=$userid&token=$token"]) ?>
        帐号:<input type="text" name="name" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id38">
    评论订单
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/orders/comment?userid=$userid&token=$token"]) ?>
        Order_id:<input type="text" name="OrderCommentForm[order_id]" /> <br />
        comment_text:<input type="text" name="OrderCommentForm[comment_text]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id38">
    评价订单
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/orders/evaluate?userid=$userid&token=$token"]) ?>
        Order_id:<input type="text" name="OrderCommentForm[order_id]" /> <br />
        comment_type:<input type="text" name="OrderCommentForm[comment_type]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>


<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id38">
    申请退货
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/orders/retreat?userid=$userid&token=$token"]) ?>
        Order_id:<input type="text" name="order_id" /> <br />
        images:<input type="text" name="images" /> <br />
        title:<input type="text" name="title" /> <br />
        text:<input type="text" name="text" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id38">
    卖家拒绝退货
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/orders/refuse?userid=$userid&token=$token"]) ?>
        Order_id:<input type="text" name="order_id" /> <br />
        images:<input type="text" name="images" /> <br />
        title:<input type="text" name="title" /> <br />
        text:<input type="text" name="text" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id37">
    卖方同意退款
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/orders/consent?userid=$userid&token=$token"]) ?>
        订单ID:<input type="text" name="order_id" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id37">
    关闭订单
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/orders/cancel?userid=$userid&token=$token"]) ?>
        订单ID:<input type="text" name="order_id" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>


<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id37">
    绑定第三方帐号
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/center/binding?userid=$userid&token=$token"]) ?>
        类型:<input type="text" name="type" /> <br />
        帐号:<input type="text" name="accounts" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id37">
    第三方登 入
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/login/other?userid=$userid&token=$token"]) ?>
        类型:<input type="text" name="type" /> <br />
        帐号:<input type="text" name="accounts" /> <br />
        nickname:<input type="text" name="nickname" /> <br />
        icon:<input type="text" name="icon" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id6">
    次元卡-上传图片
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>'/center/cardimageadd?userid='.$userid.'&token='.$token]) ?>
        images:<input id="uploadform-file" name="UploadImagesForm[file][]" multiple=""  type="file"> <br />

        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id6">
    删除照片
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>'/center/cardimagedel?userid='.$userid.'&token='.$token]) ?>
        <input type="text" name="image_id" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>


<div class="container" id="id6">
    删除多照片
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>'/center/cardimagedels?userid='.$userid.'&token='.$token]) ?>
        <input type="text" name="image_id" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id6">
    次元卡，添加作品
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>'/center/cardproductadd?userid='.$userid.'&token='.$token]) ?>
        <input type="text" name="product_id" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id6">
    次元卡，删除作品
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>'/center/cardproductdel?userid='.$userid.'&token='.$token]) ?>
        <input type="text" name="card_product_id" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id6">
    取消关注的作品
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>'/concern/cancelproduct?userid='.$userid.'&token='.$token]) ?>
        <input type="text" name="productid" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id6">
    取消关注的作品
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>'/concern/cancelstatus?userid='.$userid.'&token='.$token]) ?>
        <input type="text" name="statusid" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id6">
    支付定单
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>'/orders/pay?userid='.$userid.'&token='.$token]) ?>
        order_id:<input type="text" name="order_id" /> <br />
        pay_type<input type="text" name="paytype" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id6">
    举报
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>'/system/inform?userid='.$userid.'&token='.$token]) ?>
        type:<input type="text" name="InformForm[type]" /> <br />
        object_id:<input type="text" name="InformForm[object_id]" /> <br />
        text : <input type="text" name="InformForm[text]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id6">
    举报
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>'/system/inform?userid='.$userid.'&token='.$token]) ?>
        type:<input type="text" name="InformForm[type]" /> <br />
        object_id:<input type="text" name="InformForm[object_id]" /> <br />
        text : <input type="text" name="InformForm[text]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id6">
    提现
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>'/center/withdraw?userid='.$userid.'&token='.$token]) ?>
        moeny:<input type="text" name="WithdrawForm[money]" /> <br />
        accounts:<input type="text" name="WithdrawForm[accounts]" /> <br />
        type : <input type="text" name="WithdrawForm[type]" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>


<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id6">
    发送信息
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>'/test/hxsend?userid='.$userid.'&token='.$token]) ?>
        user:<input type="text" name="user" /> <br />
        text:<input type="text" name="text" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id6">
    意见反馈
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>'/center/feedback?userid='.$userid.'&token='.$token]) ?>
        text:<input type="text" name="content" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id6">
    环信发信息
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>'/center/hxsend?userid='.$userid.'&token='.$token]) ?>
        object:<input type="object" name="object" /> <br />
        text:<input type="object" name="text" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id6">
    日期转日期截
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>'/system/strtotime?userid='.$userid.'&token='.$token]) ?>
        dt:<input type="object" name="dt" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<div class="container" id="id38">
    退款，追加评论
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/orders/addmessage?userid=$userid&token=$token"]) ?>
        Order_id:<input type="text" name="order_id" /> <br />
        images:<input type="text" name="images" /> <br />
        title:<input type="text" name="title" /> <br />
        text:<input type="text" name="text" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>


<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id37">
    加黑名单
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/blacklist/add?userid=$userid&token=$token"]) ?>
        ID:<input type="text" name="id" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id37">
    删除黑名单
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/blacklist/delete?userid=$userid&token=$token"]) ?>
        ID:<input type="text" name="id" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id37">
    发货
    <div></div>
    <div class="upload">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>"/orders/shipments?userid=$userid&token=$token"]) ?>
        order_id:<input type="text" name="order_id" /> <br />
        express_company_name:<input type="text" name="express_company_name" /> <br />
        express_company_code:<input type="text" name="express_company_code" /> <br />
        express_number:<input type="text" name="express_number" /> <br />
        <input type="submit" value="提交" />
        <?php ActiveForm::end() ?>
    </div>
</div>

<br />------------------------------------------------------------------------------------<br />

<div class="container" id="id37">
    设置用户个人资料
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


</body>
</html>
