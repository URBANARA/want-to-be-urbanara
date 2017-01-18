import { BrowserModule } from '@angular/platform-browser';
import { NgModule, enableProdMode } from '@angular/core';
import { IonicApp, IonicModule } from 'ionic-angular';
enableProdMode();

import { CashApp } from './app.component';
import { MachinePage } from '../pages/machine/machine';
import { ModalPage } from '../pages/modal/modal';


@NgModule({
  declarations: [
    CashApp,
    MachinePage,
    ModalPage
  ],
  imports: [
    IonicModule.forRoot(CashApp)
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    CashApp,
    MachinePage,
    ModalPage
  ],
  providers: [

  ]
})
export class AppModule {
  constructor(){}
}
