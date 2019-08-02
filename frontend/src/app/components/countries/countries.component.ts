import {Component, OnInit} from '@angular/core';
import {Select, Store} from '@ngxs/store';
import {CountriesState} from '../../stores/countries/countries.state';
import {Observable} from 'rxjs';
import {CountryModel} from '../../models/country';
import {CountriesGenerateAction, CountriesLoadAction} from '../../stores/countries/countries.actions';
import {StatesLoadAction, StatesResetAction} from '../../stores/states/states.actions';
import {StatesState} from '../../stores/states/states.state';
import {CountiesResetAction} from '../../stores/counties/counties.actions';

@Component({
  selector: 'app-countries',
  templateUrl: './countries.component.html',
  styleUrls: ['./countries.component.scss']
})
export class CountriesComponent implements OnInit {

  @Select(CountriesState.items)
  countries$: Observable<CountryModel[]>;

  @Select(CountriesState.loading)
  loading$: Observable<boolean>;

  @Select(StatesState.countryId)
  selectedId$: Observable<number>;

  displayedColumns: string[] = ['name', 'averageTaxRate', 'overallTaxAmount'];

  constructor(private store: Store) {
  }

  ngOnInit() {
    this.store.dispatch(new CountriesLoadAction);
  }

  select(country: CountryModel) {
    this.store.dispatch(new StatesLoadAction(country.id));
    this.store.dispatch(new CountiesResetAction);
  }

  generate() {
    this.store.dispatch(new CountriesGenerateAction);
  }
}
