import {State, Action, Selector, StateContext} from '@ngxs/store';
import {CountriesGenerateAction, CountriesLoadAction} from './countries.actions';
import {CountryModel} from '../../models/country';
import gql from 'graphql-tag';
import {Apollo} from 'apollo-angular';
import {map, take} from 'rxjs/operators';

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
  countries: CountryModel[];
}

const generateMutation = gql`
  mutation {
    generateData {
      countries {
        id
        name
        averageTaxRate
        overallTaxAmount
      }
    }
  }
`;

interface GenerateQueryResponse {
  generateData: CountriesQueryResponse;
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

    try {
      const result = await this.apollo.query<CountriesQueryResponse>({query: countriesQuery})
        .pipe(map(({data}) => data.countries),)
        .toPromise();
      context.patchState({
        loading: false,
        items: result,
      });
    } catch (err) {
      context.patchState({
        loading: false,
      });
    }
  }

  @Action(CountriesGenerateAction)
  public async generate(context: StateContext<CountriesStateModel>) {
    context.patchState({
      loading: true,
    });

    try {
      const result = await this.apollo.mutate<GenerateQueryResponse>({mutation: generateMutation})
        .pipe(
          map(({data}) => data.generateData),
          map(({countries}) => countries),
        ).toPromise();
      context.patchState({
        loading: false,
        items: result,
      });
    } catch (err) {
      context.patchState({
        loading: false,
      });
    }
  }
}
