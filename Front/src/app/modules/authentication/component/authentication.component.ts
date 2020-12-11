import { Component, OnInit } from '@angular/core';
import { AbstractControl, FormControl, FormGroup, Validators } from '@angular/forms';
import { ApiService } from '../../../shared/services/api.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-authentication',
  templateUrl: './authentication.component.html',
  styleUrls: ['./authentication.component.css']
})
export class AuthenticationComponent implements OnInit {

  constructor(private router: Router, private apiService: ApiService) { }

  isAuthenticated: boolean = false;
  token_JWT: string;

  authForm: FormGroup = new FormGroup({
    login: new FormControl('', [Validators.required]),
    password: new FormControl('', [Validators.required]),
  })

  get login(): AbstractControl { return this.authForm.get('login'); }
  get password(): AbstractControl { return this.authForm.get('password'); }

  ngOnInit(): void {
  }

  onSubmit(): void {
    this.apiService.authenticate(this.authForm.value.login, this.authForm.value.password).subscribe(res => {

      if (res.body.success)
      {
          this.isAuthenticated = true;
          this.token_JWT = res.headers.get("authorization");
          console.log(this.token_JWT);
          //this.router.navigate(['/products']);
      }
      else {
        this.authForm.setErrors({
          loginOrPasswordInvalid: true
        });
      }
    });
  }
}
