<?php getHeader();
//debug($tmpVariable);
?>

<?php
if(isset($_GET['status'])){

    switch($_GET['status'])
    {
        case 1: echo '<script type="text/javascript">
                        alert("Gửi bình luận thành công. Đang chờ phê duyệt")
                    </script>';break;
        case -1:echo '<script type="text/javascript">
                        alert("Bạn phải đăng nhập mới được bình luận")
                    </script>';break;
        case -2:echo '<script type="text/javascript">
                        alert("Bạn phải nhập nội dung để bình luận")
                    </script>';break;
    }
}
?>
<section id="viewNews">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li><a href="#">Bài viết</a></li>
                    <li><a href="#"><?php echo  @$tmpVariable['listTopic']['Topic']['name']?></a></li>
                </ol>
            </div>
            <article class="col-sm-8">
                <div class="news_title">
                    <h2><?php echo @$tmpVariable['listTopic']['Topic']['name']?></h2>
                </div>
                <div class="v_content">
                    <p><?php echo @$tmpVariable['listTopic']['Topic']['content']?></p>
                    <p><?php echo @$tmpVariable['listTopic']['Topic']['description']?></p>
                    <iframe id="printAble" src="<?php echo  @$tmpVariable['listTopic']['Topic']['file']?>" style="width: 100%; height: 800px;" frameborder="0"></iframe>
                </div>
                <div class="author text-right">
                    <strong>Tác giả:</strong><p><?php echo @$tmpVariable['listTopic']['Topic']['author']?></p>

                </div>
                <div class="shared text-right">
                    <ul class="list-inline">
                        <li>Chia sẻ trên</li>

                        <li>
                            <?php
                            if (function_exists('showShareFacebook')) {
                                showShareFacebook($urlNow, @$tmpVariable['listTopic']['Topic']['id'],@$tmpVariable['listTopic']['Topic']['description'], 'Chuyên Lào Cai', @$tmpVariable['listTopic']['Topic']['image'], 'article');
                            }
                            if (function_exists('showLikeFacebook'))
                                showLikeFacebook();
                            ?>
                        </li>
                        <div class="g-plusone"></div>
                    </ul>
                </div>
                <div>
                    <span>Bạn có thể gửi thắc mắc tại đây</span>

                    <form id="form1" name="form1" method="post" action="<?php echo $urlHomes .'saveComment';?>">
                        <input type="hidden" value="<?php echo  @$tmpVariable['listTopic']['Topic']['id']?>" name="topicID">
                        <input type="hidden" value="<?php echo  @$tmpVariable['listTopic']['Topic']['slug']?>" name="topicSlug">
                        <input type="hidden" value="<?php echo @$_SESSION['infoUser']['User']['id'];?>" name="userID">
                        <input type="hidden" value="<?php echo @$_SESSION['infoUser']['User']['fullname'];?>" name="username">
                        <input type="hidden" value="0" name="parentID">
                        <textarea style="width:100%;" rows="4" name="content" required=""></textarea>
                        <input type="submit" name="submit" id="submit" value="Gửi" style="margin-bottom: 1em;background-color: cornflowerblue ; color: #fff!important; position: relative;padding: 6px 16px;text-align: center;text-decoration: none; border: none;float: right;"/>
                    </form>

                </div>


                <div style="margin-top: 30px">
                    <span style="font-size: 20px; color: cornflowerblue; width: 100%">Bình luận bài viết</span>
                    <div class="main_show_comment box_width_common" id="list_comment">

                        <div class="comment_item">
                            <div class="right width_comment_item width_common">
                                <?php if(!empty($tmpVariable['listCmt']) ){
                                    foreach ($tmpVariable['listCmt'] as $comment) {
                                        if($comment['Comment']['topicSlug']==$tmpVariable['listTopic']['Topic']['slug']){

                                        if($comment['Comment']['lock']==0 ){
                                        ?>
                                        <div class="width_common">
                                            <p class="full_content"><?php echo @$comment['Comment']['content'] ?></p>
                                            <div class="user_status width_common">
                                                    <span class="left txt_666 txt_11">
                                                        <a href="javascript:void(0);" class="nickname txt_666">
                                                            <b><?php echo $comment['Comment']['username'] ?></b></a></span>
                                                <span class="icon_portal icon_feedback">
                                            <a href="javascript:void(0);" style="color: brown;cursor: pointer;" id="reply<?php echo $comment['Comment']['id'] ?>"> - <b>Trả lời</b></a>
                                        </span>
                                            </div>
                                        </div>

                                        <div class="sub_comment" id="commentReply">
                                            <form id="form1" class="show_comment<?php echo $comment['Comment']['id'] ?>" name="form1" method="post" action="<?php echo $urlHomes . 'saveComment'; ?> ">
                                                <input type="hidden" value="<?php echo @$tmpVariable['listTopic']['Topic']['id'] ?>" name="topicID">
                                                <input type="hidden" value="<?php echo @$tmpVariable['listTopic']['Topic']['slug'] ?>" name="topicSlug">
                                                <input type="hidden" value="<?php echo @$_SESSION['infoUser']['User']['id']; ?>" name="userID">
                                                <input type="hidden" value="<?php echo @$_SESSION['infoUser']['User']['fullname']; ?>" name="username">
                                                <input type="hidden" value="<?php echo $comment['Comment']['id'] ?>" name="parentID">
                                                <textarea style="width:100%;" rows="4" name="content" required="" id="textComment"></textarea>
                                                <input type="submit" name="submit" id="submit" value="Gửi" style="margin-bottom: 1em;background-color: cornflowerblue ; color: #fff!important; position: relative;padding: 6px 16px;text-align: center;text-decoration: none; border: none;float: right;"/>
                                            </form>
                                        </div>

                                        <script type="text/javascript">

                                            $(document).ready(function () {
                                                $('.show_comment<?php echo $comment['Comment']['id']?>').hide();
                                                $("#reply<?php echo $comment['Comment']['id']?>").click(function () {
                                                    $(".show_comment<?php echo $comment['Comment']['id']?>").slideToggle();
                                                    $("textarea").focus();
                                                });
                                            });

                                        </script>

                                        <?php
                                                }
                                        if(!empty($comment['Comment']['child'])){
                                            foreach ($comment['Comment']['child'] as $sub){
                                        ?>
                                            <div class="sub_comment">
                                                <div class="subcomment_item width_common"><p
                                                            class="full_content"><?php echo $sub['Comment']['content'] ?></p>
                                                </div>
                                                <span class="left txt_666 txt_11"><a
                                                            class="nickname txt_666"><b><?php echo $sub['Comment']['username'] ?></b></a> </span>
                                            </div>
                                            <?php
                                        }
                                    }
}?>
                                                                           <?php
                                } }else echo 'Bài viết chưa có bình luận nào.';?>
                            </div>
                            <div class="clear">&nbsp;</div>
                        </div>
                    </div>
                </div>
                <div class="same_topic">
                    <h3>Bài viết khác</h3>
                    <ul class="list-unstyled">
                        <?php if(!empty($tmpVariable['otherData'])){
                            foreach ($tmpVariable['otherData'] as $topic){
                                ?>
                                <li style="list-style-type: none;"><a href="<?php echo $topic['Topic']['slug']?>"><?php echo $topic['Topic']['name']?></a></li>
                                <?php
                            }
                        } ?>

                    </ul>
                </div>
            </article>
            <aside class="col-sm-4">
                <div class="tin_su_kien">
                    <div class="tittle_sk">
                        <p class="text-center">Tin sự kiện</p>
                    </div>
                    <div id="slide_news3" class="owl-carousel">
                        <div class="item">
                            <?php
                            global $modelNotice;
                            $listEventNotice = $modelNotice->getTopEventNotice(5);
                            if (!empty($listEventNotice)) {
                                foreach ($listEventNotice as $key => $notice) {
                                    $urlNotice = getUrlNotice($notice['Notice']['id']);
                                    ?>
                                    <div class="new_main">
                                        <div class="new_img">
                                            <a href="<?php echo $urlNotice; ?>"><img
                                                        src="<?php if (!empty($notice['Notice']['image'])) echo $notice['Notice']['image']; ?>"
                                                        class="img-responsive" title="" alt=""></a>
                                        </div>
                                        <div class="new_text">
                                            <p><?php echo $notice['Notice']['title']; ?></p>
                                        </div>
                                    </div>
                                <?php }
                            } ?>
                        </div>

                    </div>
                </div>
                <div class="khoi2">
                    <p class="khoi2_tittle text-center">Khối chuyên</p>
                    <div class="khoi2_main">
                        <?php
                        global $modelNotice;
                        global $viewNewData;
                        $listNotice = $modelNotice->getOtherNotice(array((int)$viewNewData['Option']['value']['chamlobaove']), $limit = 4, $condition = array());
                        if (!empty($listNotice)) {
                            foreach ($listNotice as $key => $notice) {
                                $urlNotice = getUrlNotice($notice['Notice']['id']);
                                if ($key == 0) {
                                    ?>
                                    <p class="main_tittle"><strong><a
                                                    href="<?php echo $urlNotice; ?>"><?php echo $notice['Notice']['title'] ?></a></strong>
                                    </p>
                                    <div class="new_main">
                                        <div class="new_img">
                                            <a href="<?php echo $urlNotice; ?>"><img
                                                        src="<?php echo $notice['Notice']['image']; ?>"
                                                        class="img-responsive"
                                                        title="<?php echo $notice['Notice']['title']; ?>"
                                                        alt="<?php echo $notice['Notice']['title']; ?>"></a>
                                        </div>
                                        <div class="new_text">
                                            <p><?php echo $notice['Notice']['introductory']; ?></p>
                                        </div>
                                    </div>
                                <?php }
                            }
                        } ?>
                        <div class="list_new">
                            <ul>
                                <?php
                                global $modelNotice;
                                global $viewNewData;
                                $listNotice = $modelNotice->getOtherNotice(array((int)$viewNewData['Option']['value']['chamlobaove']), $limit = 4, $condition = array());
                                if (!empty($listNotice)) {
                                    foreach ($listNotice as $key => $notice) {
                                        $urlNotice = getUrlNotice($notice['Notice']['id']);
                                        if ($key != 0) {
                                            ?>
                                            <a href="<?php echo $urlNotice; ?>">
                                                <li><?php echo $notice['Notice']['title']; ?></li>
                                            </a>
                                        <?php }
                                    }
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="khoi2">
                    <p class="khoi2_tittle text-center">Cựu học sinh</p>
                    <div class="khoi2_main">
                        <?php
                        global $modelNotice;
                        global $viewNewData;
                        if (!empty($viewNewData['Option']['value']['thiduakhenthuong'])) {
                            $listNotice = $modelNotice->getOtherNotice(array((int)$viewNewData['Option']['value']['thiduakhenthuong']), $limit = 4, $condition = array());
                            if (!empty($listNotice)) {
                                foreach ($listNotice as $key => $notice) {
                                    $urlNotice = getUrlNotice($notice['Notice']['id']);
                                    if ($key == 0) {
                                        ?>
                                        <p class="main_tittle"><strong><a
                                                        href="<?php echo $urlNotice; ?>"><?php echo $notice['Notice']['title'] ?></a></strong>
                                        </p>
                                        <div class="new_main">
                                            <div class="new_img">
                                                <a href="<?php echo $urlNotice; ?>"><img
                                                            src="<?php echo $notice['Notice']['image']; ?>"
                                                            class="img-responsive"
                                                            title="<?php echo $notice['Notice']['title']; ?>"
                                                            alt="<?php echo $notice['Notice']['title']; ?>"></a>
                                            </div>
                                            <div class="new_text">
                                                <p><?php echo $notice['Notice']['introductory']; ?></p>
                                            </div>
                                        </div>
                                    <?php }
                                }
                            }
                        } ?>
                        <div class="list_new">
                            <ul>
                                <?php
                                global $modelNotice;
                                global $viewNewData;
                                if (!empty($viewNewData['Option']['value']['thiduakhenthuong'])) {
                                    $listNotice = $modelNotice->getOtherNotice(array((int)$viewNewData['Option']['value']['thiduakhenthuong']), $limit = 4, $condition = array());
                                    if (!empty($listNotice)) {
                                        foreach ($listNotice as $key => $notice) {
                                            $urlNotice = getUrlNotice($notice['Notice']['id']);
                                            if ($key != 0) {
                                                ?>
                                                <a href="<?php echo $urlNotice; ?>">
                                                    <li><?php echo $notice['Notice']['title']; ?></li>
                                                </a>
                                            <?php }
                                        }
                                    }
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="khoi2">
                    <p class="khoi2_tittle text-center">Học bổng - Du học</p>
                    <div class="khoi2_main">
                        <?php
                        global $modelNotice;
                        global $viewNewData;
                        if (!empty($viewNewData['Option']['value']['congtacnucongvagioi'])) {
                            $listNotice = $modelNotice->getOtherNotice(array((int)$viewNewData['Option']['value']['congtacnucongvagioi']), $limit = 4, $condition = array());
                            if (!empty($listNotice)) {
                                foreach ($listNotice as $key => $notice) {
                                    $urlNotice = getUrlNotice($notice['Notice']['id']);
                                    if ($key == 0) {
                                        ?>
                                        <p class="main_tittle"><strong><a
                                                        href="<?php echo $urlNotice; ?>"><?php echo $notice['Notice']['title'] ?></a></strong>
                                        </p>
                                        <div class="new_main">
                                            <div class="new_img">
                                                <a href="<?php echo $urlNotice; ?>"><img
                                                            src="<?php echo $notice['Notice']['image']; ?>"
                                                            class="img-responsive"
                                                            title="<?php echo $notice['Notice']['title']; ?>"
                                                            alt="<?php echo $notice['Notice']['title']; ?>"></a>
                                            </div>
                                            <div class="new_text">
                                                <p><?php echo $notice['Notice']['introductory']; ?></p>
                                            </div>
                                        </div>
                                    <?php }
                                }
                            }
                        } ?>
                        <div class="list_new">
                            <ul>
                                <?php
                                global $modelNotice;
                                global $viewNewData;
                                if (!empty($viewNewData['Option']['value']['congtacnucongvagioi'])) {
                                    $listNotice = $modelNotice->getOtherNotice(array((int)$viewNewData['Option']['value']['congtacnucongvagioi']), $limit = 4, $condition = array());
                                    if (!empty($listNotice)) {
                                        foreach ($listNotice as $key => $notice) {
                                            $urlNotice = getUrlNotice($notice['Notice']['id']);
                                            if ($key != 0) {
                                                ?>
                                                <a href="<?php echo $urlNotice; ?>">
                                                    <li><?php echo $notice['Notice']['title']; ?></li>
                                                </a>
                                            <?php }
                                        }
                                    }
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>

            </aside>
        </div>
    </div>
</section>
<style type="text/css">
    .subcomment_item {
        padding-top: 5px;
        margin-bottom: 5px;
        border-top: 1px dotted #e2e2e3;
    }

    .width_common {
        width: 100%;
        float: left;
    }
    .sub_comment {
        float: right;
        width: 95%;
        padding: 5px 0 0;
    }
    .comment_item{
        border-top: 1px dotted #e2e2e3;
    }
    .input_comment {
        padding: 0 0 10px;
        background: none;
        margin-bottom: 10px;
        border-bottom: 1px dotted #e2e2e3;
        background: #f5f5f5;
        position: relative;
        z-index: 2;
    }
    .block_input_comment .input_comment textarea {
        font: 400 12px/18px arial;
        background: #fff;
        border: 1px solid #c5c5c5;
        width: 98.5%;
        color: #666;
        overflow: hidden;
        padding: 5px 0 0 1%;
        float: right;
        height: 50px;
    }


</style>
