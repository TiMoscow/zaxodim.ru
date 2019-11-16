<?php
/**
 * @package     Joomla.site
 * @subpackage  Component.hwdmediashare
 *
 * @copyright   Copyright (C) 2013 Highwood Design Limited. All rights reserved.
 * @license     GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @author      Dave Horsfall
 */

defined('_JEXEC') or die;

// Load Mootools JavaScript Framework.
JHtml::_('behavior.framework');
JHtml::_('behavior.core');

// Load tooltip behavior.
JHtml::_('behavior.tooltip');

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/helpers/html');
JHtml::_('HwdPopup.iframe', 'page');

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', '.hwd-form-catid', null, array('placeholder_text_multiple' => JText::_('COM_HWDMS_UPLOADS_SELECT_CATEGORY')));
JHtml::_('formbehavior.chosen', '.hwd-form-tags', null, array('placeholder_text_multiple' => JText::_('COM_HWDMS_UPLOADS_SELECT_TAGS')));
JHtml::_('formbehavior.chosen', 'select');

$user = JFactory::getUser();
?>   
<form action="<?php echo JRoute::_('index.php?option=com_hwdmediashare'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
  <div id="hwd-container" class="<?php echo $this->pageclass_sfx;?>"> <!-- a name="top" id="top"></a --> <a id="top"></a>
    <!-- Media Navigation -->
    <?php echo hwdMediaShareHelperNavigation::getInternalNavigation(); ?>
    <!-- Media Header -->
    <div class="media-header">
      <h2 class="media-upload-title"></h2>
    </div>   
    <?php if ($user->authorise('hwdmediashare.upload', 'com_hwdmediashare') && $this->params->get('enable_uploads_file') == "1") : ?>
    <fieldset>
      <div class="row-fluid">
        <div class="span8"> 
          <div id="hwd-upload-fallback" class="control-group">
            <div class="control-label hide">
              <?php echo $this->form->getLabel('Filedata'); ?>
            </div>                  
            <div class="controls">
              <?php echo $this->form->getInput('Filedata'); ?>
            </div>
            <div class="clearfix"></div>  
          </div> 
          <div id="hwd-upload-buttons" class="control-group hide" >
            <a href="#" id="hwd-upload-browse" class="btn span6"><?php echo JText::_('COM_HWDMS_BROWSE_FILES'); ?></a>
            <a href="#" id="hwd-upload-clear" class="btn span6"><?php echo JText::_('COM_HWDMS_CLEAR_LIST'); ?></a>
            <div class="clearfix"></div>  
          </div>
          <?php if ($this->params->get('enable_categories')): ?>
          <div class="control-group">
            <div class="control-label hide">
              <?php echo $this->form->getLabel('catid'); ?>
            </div>              
            <div class="controls">
              <?php echo $this->form->getInput('catid'); ?>
            </div>
          </div>                          
          <?php endif; ?>            
          <?php if ($this->params->get('enable_tags')): ?>
          <div class="control-group">
            <div class="control-label hide">
              <?php echo $this->form->getLabel('tags'); ?>
            </div>              
            <div class="controls">
              <?php echo $this->form->getInput('tags'); ?>
            </div>
          </div>    
          <?php endif; ?>              
        </div>
        <div class="span4">
          <div class="control-group">
            <div class="controls">
              <?php echo $this->form->getInput('private'); ?>
            </div>
          </div> 
          <div class="btn-toolbar row-fluid">
            <button id="hwd-upload-upload" type="submit" class="btn btn-primary validate btn-large span12">
              <?php echo JText::_('COM_HWDMS_BUTTON_UPLOAD') ?>
            </button>
          </div> 
          <?php if ($this->params->get('enable_uploads_remote')): ?>
          <div class="btn-toolbar row-fluid">
            <a title="<?php echo JText::_('COM_HWDMS_ADD_REMOTE_MEDIA'); ?>" href="<?php echo JRoute::_(hwdMediaShareHelperRoute::getUploadRoute(array('method' => 'remote'))); ?>" class="btn span12"><?php echo JText::_('COM_HWDMS_BUTTON_OR_ADD_REMOTE_MEDIA'); ?></a>
          </div>             
          <?php endif; ?>    
        </div>
      </div>  
      <div id="hwd-upload-status" class="hide">
        <div>
          <span class="overall-title"></span>
          <div class="hwd-upload-progress overall-progress">
            <div id="overall-progress-active" style="width:0;"></div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div>
          <span class="current-title"></span>
          <div class="hwd-upload-progress current-progress">
            <div id="current-progress-active" style="width:0;"></div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="current-text"></div>
        <div class="clearfix"></div>
        <ul id="hwd-upload-list"></ul>
      </div>        
      <div class="clearfix"></div>
      <div class="well well-small">
        <h3><?php echo JText::_('COM_HWDMS_HELP_AND_SUGGESTIONS'); ?></h3>
        <?php if ($this->params->get('upload_terms_id')): ?>
          <p><?php echo JText::sprintf('COM_HWDMS_ACKNOWLEDGE_TERMS_AND_CONDITIONS', '<a href="' . JRoute::_('index.php?option=com_content&view=article&id=' . $this->params->get('upload_terms_id') . '&tmpl=component') . '" class="media-popup-iframe-page">' . JText::_('COM_HWDMS_TERMS_AND_CONDITIONS_LINK') . '</a>'); ?></p>      
        <?php endif; ?>
        <p><?php echo JText::sprintf('COM_HWDMS_SUPPORTED_FORMATS_LIST_X', implode(', ', $this->localExtensions)); ?> <?php echo JText::sprintf('COM_HWDMS_MAXIMUM_UPLOAD_SIZE_X', (hwdMediaShareUpload::getMaximumUploadSize('standard')/1048576)); ?></p>
      </div> 
    </fieldset> 
    <?php endif; ?>
    <input type="hidden" name="task" value="addmedia.upload" />
    <input type="hidden" name="return" value="<?php echo $this->return; ?>" />
    <?php foreach($this->jformdata as $name => $value): ?>
      <?php if (is_array($value)) : ?>
        <?php foreach($value as $key => $id): ?>
          <?php if (!empty($id)) : ?><input type="hidden" name="jform[<?php echo $name; ?>][]" value="<?php echo $id; ?>" /><?php endif; ?>
        <?php endforeach; ?>
      <?php elseif(!empty($value)): ?>
        <input type="hidden" name="jform[<?php echo $name; ?>]" value="<?php echo $value; ?>" />
      <?php endif; ?>
    <?php endforeach; ?> 
    <?php // The token breaks the XML redirect file for uber, so it is removed by the uber javascript ?>
    <input type="hidden" name="<?php echo JSession::getFormToken(); ?>" id="formtoken" value="1" />
  </div>
</form>
