import {State, Action, Selector, StateContext} from '@ngxs/store';
import {CountriesLoadAction} from './countries.actions';
import {CountryModel} from '../../models/country';
import gql from 'graphql-tag';
import {Apollo} from 'apollo-angular';
import {map} from 'rxjs/operators';

const countriesQuery = gql`
  {
    countries {
      id
      name
      averageTaxRate
      overallTaxAmount
    }
  }
`;

interface CountriesQueryResponse {
  countries: CountryModel[]
}

export interface CountriesStateModel {
  loading: boolean;
  items: CountryModel[];
}

@State<CountriesStateModel>({
  name: 'countries',
  defaults: {
    loading: false,
    items: []
  }
})
export class CountriesState {
  constructor(private apollo: Apollo) {
  }

  @Selector()
  public static state(state: CountriesStateModel) {
    return state;
  }

  @Selector()
  public static items(state: CountriesStateModel) {
    return state.items;
  }

  @Selector()
  public static loading(state: CountriesStateModel) {
    return state.loading;
  }

  @Action(CountriesLoadAction)
  public async load(context: StateContext<CountriesStateModel>) {
    context.patchState({
      loading: true,
    });
    await this.apollo.query<CountriesQueryResponse>({query: countriesQuery})
      .pipe(map(({data}) => data.countries))
      .toPromise()
      .then(countries => {
        context.patchState({
          loading: false,
          items: countries,
        });
      });
  }
}
