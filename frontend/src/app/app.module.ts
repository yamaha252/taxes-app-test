import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';
import {AppComponent} from './components/app.component';
import {GraphQLModule} from './modules/graphql.module';
import {HttpClientModule} from '@angular/common/http';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {MatCardModule, MatProgressSpinnerModule, MatTableModule} from '@angular/material';
import {NgxsModule} from '@ngxs/store';
import {CountriesState} from './stores/countries/countries.state';
import {StatesState} from './stores/states/states.state';
import {CountiesState} from './stores/counties/counties.state';
import {CountriesComponent} from './components/countries/countries.component';
import {CountiesComponent} from './components/counties/counties.component';
import {StatesComponent} from './components/states/states.component';

@NgModule({
  declarations: [
    AppComponent,
    CountriesComponent,
    CountiesComponent,
    StatesComponent
  ],
  imports: [
    BrowserModule,
    GraphQLModule,
    HttpClientModule,
    BrowserAnimationsModule,
    NgxsModule.forRoot([
      CountriesState,
      StatesState,
      CountiesState,
    ]),
    MatTableModule,
    MatProgressSpinnerModule,
    MatCardModule,
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule {
}
