import {Component, OnInit} from '@angular/core';
import {Select, Store} from '@ngxs/store';
import {CountriesState} from '../../stores/countries/countries.state';
import {Observable} from 'rxjs';
import {CountryModel} from '../../models/country';
import {CountriesLoadAction} from '../../stores/countries/countries.actions';
import {StatesLoadAction} from '../../stores/states/states.actions';
import {StatesState} from '../../stores/states/states.state';
import {CountiesCleanAction} from '../../stores/counties/counties.actions';

@Component({
  selector: 'app-countries',
  templateUrl: './countries.component.html',
  styleUrls: ['./countries.component.css']
})
export class CountriesComponent implements OnInit {

  @Select(CountriesState.items)
  countries$: Observable<CountryModel[]>;

  @Select(CountriesState.loading)
  loading$: Observable<boolean>;

  @Select(StatesState.countryId)
  selectedId$: Observable<number>;

  displayedColumns: string[] = ['id', 'name', 'averageTaxRate', 'overallTaxAmount'];

  constructor(private store: Store) {
  }

  ngOnInit() {
    this.store.dispatch(new CountriesLoadAction);
  }

  select(country: CountryModel) {
    this.store.dispatch(new StatesLoadAction(country.id));
    this.store.dispatch(new CountiesCleanAction());
  }
}
