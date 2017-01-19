import { Component, ViewChild } from '@angular/core';
import { ToastController, Platform, MenuController, Nav } from 'ionic-angular';
import { StatusBar, Splashscreen } from 'ionic-native';

import { MachinePage } from '../pages/machine/machine';
import { ModalPage } from '../pages/modal/modal';

@Component({
  templateUrl: 'app.html'
})
export class CashApp {

  @ViewChild(Nav) nav: Nav;

  rootPage: any = MachinePage;
  pages: Array<{title: string, component: any}>;

  constructor(
    public platform: Platform,
    public menu: MenuController
  ) {
    this.initializeApp();

    this.pages = [
      { title: 'Machine', component: MachinePage }
    ];
  }

  initializeApp() {
    this.platform.ready().then(() => {
      Splashscreen.hide();
      StatusBar.styleDefault();
    });
  }

  openPage(page) {
    this.menu.close();
    this.nav.setRoot(page.component);
  }
}
