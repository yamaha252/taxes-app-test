import {State, Action, Selector, StateContext} from '@ngxs/store';
import {StatesLoadAction, StatesResetAction} from './states.actions';
import {StateModel} from '../../models/state';
import gql from 'graphql-tag';
import {Apollo} from 'apollo-angular';
import {map} from 'rxjs/operators';

const countryQuery = gql`
  query($countryId: Int!) {
    country(id: $countryId) {
      states {
        id
        name
        overallTaxAmount
        averageTaxAmount
        averageTaxRate
      }
    }
  }
`;

interface CountryQueryResponse {
  country: {
    states: StateModel[];
  }
}

export interface StatesStateModel {
  loading: boolean;
  countryId: number;
  items: StateModel[];
}

const statesDefaultStateModel: StatesStateModel = {
  loading: false,
  countryId: null,
  items: [],
};

@State<StatesStateModel>({
  name: 'states',
  defaults: statesDefaultStateModel,
})
export class StatesState {
  constructor(private apollo: Apollo) {
  }

  @Selector()
  public static state(state: StatesStateModel) {
    return state;
  }

  @Selector()
  public static items(state: StatesStateModel) {
    return state.items;
  }

  @Selector()
  public static loading(state: StatesStateModel) {
    return state.loading;
  }

  @Selector()
  public static countryId(state: StatesStateModel) {
    return state.countryId;
  }

  @Action(StatesResetAction)
  public reset(context: StateContext<StatesStateModel>) {
    context.setState(statesDefaultStateModel);
  }

  @Action(StatesLoadAction)
  public async load(context: StateContext<StatesStateModel>, {countryId}: StatesLoadAction) {
    context.patchState({
      countryId,
      loading: true,
    });
    await this.apollo.query<CountryQueryResponse>({query: countryQuery, variables: {countryId}})
      .pipe(map(({data}) => data.country.states))
      .toPromise()
      .then(states => {
        context.patchState({
          loading: false,
          items: states,
        });
      });
  }


}
