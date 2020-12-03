import { Component } from '@angular/core';
import { Router, RouterModule } from '@angular/router';
import { environment } from '../environments/environment';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})

export class AppComponent {
  env = environment;
  router: string;

  constructor(private _router: Router)
  {
    this.router = _router.url;
  }
}
