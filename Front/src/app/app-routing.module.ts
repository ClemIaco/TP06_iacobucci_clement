import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { DetailComponent } from './modules/detail/component/detail.component';
import { FormulaireComponent } from './modules/formulaire/component/formulaire.component';
import { RecapitulatifComponent } from './modules/recapitulatif/component/recapitulatif.component';
import { HomeComponent } from './components/home/home.component';
import { ProductListComponent } from './modules/product-list/component/product-list.component';
import { SearchEngineComponent } from './modules/search-engine/component/search-engine.component';
import { StoreComponent } from './modules/store/component/store.component';
import { AuthenticationComponent } from './modules/authentication/component/authentication.component'

const routes: Routes = [
  { path: 'client-account', loadChildren: () => import('./modules/formulaire/formulaire.module').then(m => m.FormulaireModule)},
  { path: 'auth', loadChildren: () => import('./modules/authentication/authentication.module').then(m => m.AuthenticationModule)},
  { path: 'products', loadChildren: () => import('./modules/search-engine/search-engine.module').then(m => m.SearchEngineModule)},
  { path: 'store', loadChildren: () => import('./modules/store/store.module').then(m => m.StoreModule)},
  { path: 'detail/:id', loadChildren: () => import('./modules/detail/detail.module').then(m => m.DetailModule)},
  { path: '', component: HomeComponent},
  { path: '**', component: HomeComponent}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})

export class AppRoutingModule { }
