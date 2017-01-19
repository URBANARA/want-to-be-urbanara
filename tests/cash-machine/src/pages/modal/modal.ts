import { Component } from '@angular/core';
import { NavController, MenuController, ModalController, Platform, NavParams, ViewController } from 'ionic-angular';

@Component({
  templateUrl: 'modal.html'
})
export class ModalPage {

  private cash:Array<any>;

  constructor(public navCtrl: NavController,
              public menuCtrl: MenuController,
              public platform: Platform,
              public params: NavParams,
              public viewCtrl: ViewController)
  {
      this.cash = this.params.get("listCash");
  }

  ionViewDidEnter(){
    this.menuCtrl.enable(false);
    this.menuCtrl.swipeEnable(false);
  }

  dismiss() {
    this.viewCtrl.dismiss();
  }

}
