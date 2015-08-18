<?php
  /**
   * File Manager
   *
   * @package Webkokteyli CMS
   * @author Webkokteyli Lab / http://www.webkokteyli.com
   * @copyright 2015
   * @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  if(!$user->getAcl("FM")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
  
  require_once (BASEPATH . "lib/class_fm.php");
  Registry::set('FileManager', new FileManager());
  
  $result = Registry::get('FileManager')->renderAll();
?>
<div class="wk icon heading message mortar"> <i class="folder icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_FM_TITLE;?> </div>
    <div class="wk breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_FM;?></div>
    </div>
  </div>
</div>
<div class="wk-large-content">
  <div class="wk message"><?php echo Core::langIcon();?><?php echo Lang::$word->_FM_INFO;?></div>
  <div class="wk stacked segment">
    <div class="clearfix">
      <?php foreach($result['crumbs'] as $k => $crumb):?>
      <?php if($k != Lang::$word->_FM_HOME)?>
      <a class="wk large label" href="<?php echo $crumb;?>"><?php echo $k;?></a>
      <?php endforeach;?>
      <div class="wk buttons push-right"> <a onclick="$('#extra').slideToggle();" class="wk positive button"><i class="icon disk upload"></i><?php echo Lang::$word->_FM_MFILEUPL;?></a> <a onclick="$('#extra2').slideToggle();" class="wk info button"><i class="icon add"></i><?php echo Lang::$word->_FM_ADD_NEW;?></a> </div>
    </div>
    <div class="wk form">
      <div id="extra2" style="display:none">
        <div class="wk attached divider"></div>
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_FM_NAME_DIR;?></label>
            <div class="wk action input">
              <input name="newdir" placeholder="<?php echo Lang::$word->_FM_ADD_NEW_DIR_I;?>" type="text">
              <a id="newFolder" data-path="<?php echo Registry::get('FileManager')->rel_dir;?>" data-content="<?php echo Lang::$word->_FM_ADD_NEW_DIR;?>" class="wk icon positive button"><i class="icon folder"></i></a> </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_FM_NAME;?></label>
            <div class="wk action input">
              <input name="newfile" placeholder="<?php echo Lang::$word->_FM_ADD_NEW_FILE_I;?>" type="text">
              <a id="newFile" data-path="<?php echo Registry::get('FileManager')->rel_dir;?>" data-content="<?php echo Lang::$word->_FM_ADD_NEW_FILE;?>" class="wk icon secondary button"><i class="icon file"></i></a> </div>
          </div>
        </div>
      </div>
      <div id="extra" style="display:none">
        <div class="wk attached divider"></div>
        <div id="uploader">
          <form id="upload" method="post" action="controller.php" enctype="multipart/form-data">
            <div id="drop" class="fade well"> <?php echo Lang::$word->_FM_DROPHERE;?> <a id="upl"><?php echo Lang::$word->_BROWSE;?></a>
              <input type="file" name="mainfile" multiple />
              <input name="doFM" type="hidden" value="1">
              <input name="fmact" type="hidden" value="doUpload">
              <input name="fdirectory" type="hidden" value="<?php echo Registry::get('FileManager')->rel_dir;?>">
            </div>
            <ul>
            </ul>
          </form>
        </div>
      </div>
      <div class="wk double fitted divider"></div>
      <div class="wk divided list" id="dirlist">
        <?php foreach ($result['dirs'] as $i => $dir):?>
        <div class="item">
          <?php if($dir['type'] == 'back'):?>
          <a href="<?php echo $dir['link'];?>"> <i class="icon ellipsis horizontal"></i> <?php echo $dir['name'];?> </a>
          <?php else:?>
          <?php $i++;?>
          <a class="left floated wk small button" data-id="<?php echo $i;?>" href="index.php?do=filemanager&amp;cdir=<?php echo urlencode($dir['link']);?>"> <i class="icon folder"></i> <?php echo $dir['name'];?> </a> <a class="remdir right floated" data-path="<?php echo $dir['path'];?>" data-name="<?php echo $dir['name'];?>"><i class="rounded danger inverted trash icon link"></i></a>
          <?php endif;?>
        </div>
        <?php endforeach;?>
      </div>
    </div>
  </div>
  <div class="wk stacked segment">
    <table class="wk sortable table" id="tableEdit">
      <thead>
        <tr>
          <th class="disabled"><i class="file icon"></i></th>
          <th data-sort="string"><?php echo Lang::$word->_FM_NAME;?></th>
          <th data-sort="int"><?php echo Lang::$word->_FM_SIZE;?></th>
          <th data-sort="string"><?php echo Lang::$word->_FM_TYPE;?></th>
          <th data-sort="int"><?php echo Lang::$word->_FM_UPLOADED;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($result['files'] as $i => $file):?>
        <?php $i++;?>
        <tr>
          <td><img src="assets/images/mime/small/<?php echo $file['ext'];?>" alt="" /></td>
          <td><span class="edit" data-id="<?php echo $i;?>" data-dir="<?php echo $file['dir'];?>" data-name="<?php echo $file['fname'];?>"> <?php echo $file['fname'];?></span></td>
          <td data-sort-value="<?php echo $file['fsize'];?>"><?php echo $file['size'];?></td>
          <td><?php echo $file['mime'];?></td>
          <td data-sort-value="<?php echo $file['time'];?>"><?php echo date('d-m-Y', filemtime(UPLOADS . $file['path']));?></td>
          <td><?php if($file['type'] == "image"):?>
            <a href="<?php echo UPLOADURL . $file['path'];?>" title="<?php echo $file['fname'];?>" class="lightbox"><i class="circular success unhide icon link"></i></a>
            <?php endif;?>
            <a class="remove" data-name="<?php echo $file['fname'];?>" data-dir="<?php echo $file['dir'];?>" data-path="<?php echo $file['path'];?>"><i class="circular danger remove icon link"></i></a></td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
  <div class="half-top-space">
    <div class="wk large info label"><?php echo Lang::$word->_FM_DIRS . ': <span id="dcount">' . $result['dir_count'].'</span> ' . Lang::$word->_FM_FILES . ': <span id="fcount">' . $result['file_count'] . '</span>';?></div>
  </div>
</div>
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
    $.fileManager({
        msg: {
            renempty: "<?php echo Lang::$word->_FM_EMPTY;?>",
            renfile: "<?php echo Lang::$word->_FM_RENAME;?>",
            delfilea: "<?php echo Lang::$word->_FM_DELMSG;?>",
            delfileb: "<?php echo Lang::$word->_DEL_CONFIRM1;?>",
            delfilec: "<?php echo Lang::$word->_FM_DELETE;?>",
            deldirc: "<?php echo Lang::$word->_FM_DELETE_D;?>",
            del: "<?php echo Lang::$word->_DELETE;?>"
        }
    });
});
// ]]>
</script>