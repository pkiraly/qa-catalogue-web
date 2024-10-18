{* variables:
   - value: the value of a subfield
*}{if is_string($value)}{$value}{elseif is_array($value)}{join(', ', $value)}{/if}
