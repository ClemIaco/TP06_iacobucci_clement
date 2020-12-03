import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { RecapitulatifComponent } from './recapitulatif.component';

const routes : Routes = [
    {
      path: '', component: RecapitulatifComponent
    }
]
  
  @NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
  })

export class RecapitulatifRoutingModule { }