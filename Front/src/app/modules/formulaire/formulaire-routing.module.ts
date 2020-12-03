import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SearchEngineComponent } from '../search-engine/component/search-engine.component';
import { RouterModule, Routes } from '@angular/router';
import { FormulaireComponent } from './component/formulaire.component';

const routes : Routes = [
  {
    path: '', component: FormulaireComponent
    //path: 'client-account', component: FormulaireComponent
  }
]

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class FormulaireRoutingModule { }
