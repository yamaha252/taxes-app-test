import {Component} from '@angular/core';
import {MatDialog} from '@angular/material';
import {ConfirmationDialogComponent} from './confirmation-dialog/confirmation-dialog.component';
import {filter, take} from 'rxjs/operators';
import {Store} from '@ngxs/store';
import {CountriesGenerateAction} from '../stores/countries/countries.actions';
import {StatesResetAction} from '../stores/states/states.actions';
import {CountiesResetAction} from '../stores/counties/counties.actions';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  constructor(private dialog: MatDialog,
              private store: Store) {
  }

  generate() {
    const dialogRef = this.dialog.open(ConfirmationDialogComponent, {
      data: {
        caption: 'Data generation',
        text: 'Are you sure you want to regenerate data?',
      }
    });
    dialogRef.afterClosed().pipe(
      filter(result => result),
      take(1)
    ).subscribe(() => {
      this.store.dispatch(new CountriesGenerateAction);
      this.store.dispatch(new StatesResetAction);
      this.store.dispatch(new CountiesResetAction);
    });
  }
}
