import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { StoreComponent } from './component/store.component';
import { RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  {
    path: '', component: StoreComponent
  }
]

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class StoreRoutingModule { }
