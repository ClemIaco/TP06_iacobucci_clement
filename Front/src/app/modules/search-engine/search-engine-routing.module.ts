import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SearchEngineComponent } from './component/search-engine.component';
import { RouterModule, Routes } from '@angular/router';

const routes : Routes = [
  {
    path: '', component: SearchEngineComponent
  }
]

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class SearchEngineRoutingModule { }
