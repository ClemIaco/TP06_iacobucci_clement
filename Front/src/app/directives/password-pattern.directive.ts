import { Directive } from '@angular/core';    
import { NG_VALIDATORS, Validator, AbstractControl } from '@angular/forms';    
import { CustomFormValidationsService } from '../shared/services/custom-form-validations.service';    
    
@Directive({    
  selector: '[appPasswordPattern]',    
  providers: [{ provide: NG_VALIDATORS, useExisting: PasswordPatternDirective, multi: true }]    
})    
export class PasswordPatternDirective implements Validator {    
    
  constructor(private customValidator: CustomFormValidationsService) { }    
    
  validate(control: AbstractControl): { [key: string]: any } | null {    
    return this.customValidator.patternValidator()(control);    
  }    
} 
