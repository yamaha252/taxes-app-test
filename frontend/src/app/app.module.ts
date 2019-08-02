import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';
import {AppComponent} from './components/app.component';
import {GraphQLModule} from './modules/graphql.module';
import {HttpClientModule} from '@angular/common/http';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {
  MatButtonModule,
  MatCardModule, MatDialogModule,
  MatIconModule,
  MatProgressSpinnerModule, MatRippleModule,
  MatTableModule,
  MatToolbarModule, MatTooltipModule
} from '@angular/material';
import {NgxsModule} from '@ngxs/store';
import {CountriesState} from './stores/countries/countries.state';
import {StatesState} from './stores/states/states.state';
import {CountiesState} from './stores/counties/counties.state';
import {CountriesComponent} from './components/countries/countries.component';
import {CountiesComponent} from './components/counties/counties.component';
import {StatesComponent} from './components/states/states.component';
import {ConfirmationDialogComponent} from './components/confirmation-dialog/confirmation-dialog.component';
import {A11yModule} from '@angular/cdk/a11y';

@NgModule({
  declarations: [
    AppComponent,
    CountriesComponent,
    CountiesComponent,
    StatesComponent,
    ConfirmationDialogComponent
  ],
  entryComponents: [
    ConfirmationDialogComponent,
  ],
  imports: [
    A11yModule,
    BrowserModule,
    GraphQLModule,
    HttpClientModule,
    BrowserAnimationsModule,
    NgxsModule.forRoot([
      CountriesState,
      StatesState,
      CountiesState,
    ]),
    MatToolbarModule,
    MatButtonModule,
    MatIconModule,
    MatTableModule,
    MatProgressSpinnerModule,
    MatCardModule,
    MatRippleModule,
    MatTooltipModule,
    MatDialogModule,
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule {
}
