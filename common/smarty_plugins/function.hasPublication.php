<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.assign.php
 * Type:     function
 * Name:     assign
 * Purpose:  assign a value to a template variable
 * -------------------------------------------------------------
 */
function smarty_function_hasPublication($params, Smarty_Internal_Template $template)
{
  if (!empty($params['doc']->{'260a_Publication_place_ss'})
      || !empty($params['doc']->{'260b_Publication_agent_ss'})
      || !empty($params['doc']->{'260c_Publication_date_ss'})) {
    return TRUE;
  }
  return FALSE;
}