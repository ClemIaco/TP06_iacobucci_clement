import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RecapitulatifComponent} from './recapitulatif.component'
import { ReactiveFormsModule } from '@angular/forms';
import { RecapitulatifRoutingModule } from './recapitulatif-routing.module';
import { HttpClientModule } from '@angular/common/http';
import { ApiService } from '../services/api.service';


@NgModule({
  declarations: [
    RecapitulatifComponent
  ],
  imports: [
    CommonModule,
    ReactiveFormsModule,
    RecapitulatifRoutingModule,
    HttpClientModule
  ],
  providers: [
    ApiService
  ]
})
export class RecapitulatifModule { }