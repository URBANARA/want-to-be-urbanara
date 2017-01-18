import { Component } from '@angular/core';
import { AlertController, ToastController, NavController, MenuController, ModalController } from 'ionic-angular';
import { ModalPage } from '../modal/modal'

@Component({
  templateUrl: 'machine.html'
})
export class MachinePage {

  public listCash:Array<number> = [];
  private cashListaGet:Array<number> = [];
  private cash:number;

  constructor(public navCtrl: NavController,
              public menuCtrl: MenuController,
              public modalCtrl: ModalController,
              public alertCtrl: ToastController
              )
  {}

  ionViewDidEnter(){
    this.menuCtrl.enable(false);
    this.menuCtrl.swipeEnable(false);
  }

  seeCashList(){
    if(this.cash != null && this.cash > 0){
      this.presentModal(this.takeCash(this.cash));
    } else {
      if(this.cash < 0){
        this.toastCash("Oops, some wrong!")
      }else{
        this.toastCash("Oops, forget the cash!")
      }
    }
  }

  private takeCash(cash:number):any{

    let money = [100,50,20,10];
    let returnList:Array<any> = [];
    let cashNew = cash;
    let rest;

    money.forEach(x => {
      if (cashNew >= x){
        rest = cashNew % x;
        if(rest == 0){
          let n = Math.floor(cashNew / x);
          returnList.push({"value":n,"money":x})
          cashNew = rest;
        }else{
          let n = Math.floor(cashNew / x);
          returnList.push({"value":n,"money":x})
          cashNew = rest;
        }
      }
    })
    if (cashNew < 10 && cashNew > 0){
      this.toastCash("We only have note of 100, 50, 20, 10");
      this.cash = null;
      return [];
    }
    return returnList;

  }


  presentModal(listTakeCash:Array<any>) {
    if(listTakeCash.length > 0){
      let modal = this.modalCtrl.create(ModalPage, {"listCash": listTakeCash});
      modal.present();
      modal.onDidDismiss(data => {
        this.cashListaGet.push(this.cash);
        this.cash = null;
        this.toastCash("Thanks for use Cash Machine");
      });
    }
  }

  eraseCash(){
    this.cash = null;
    this.cashListaGet = [];
  }

  toastCash(msg:string){
      let alert = this.alertCtrl.create({
        message: msg,
        duration: 5000,
        position: 'bottom'
      });
      alert.present()
  }

}
