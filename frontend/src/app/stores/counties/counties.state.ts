import {State, Action, Selector, StateContext} from '@ngxs/store';
import {CountiesLoadAction, CountiesResetAction} from './counties.actions';
import {CountyModel} from '../../models/county';
import {Apollo} from 'apollo-angular';
import gql from 'graphql-tag';
import {map} from 'rxjs/operators';

const stateQuery = gql`
  query($stateId: Int!) {
    state(id: $stateId) {
      counties {
        id
        name
        taxRate
        taxAmount
      }
    }
  }
`;

interface StateQueryResponse {
  state: {
    counties: CountyModel[];
  }
}

export interface CountiesStateModel {
  loading: boolean;
  stateId: number;
  items: CountyModel[];
}

const countiesDefaultStateModel: CountiesStateModel = {
  loading: false,
  stateId: null,
  items: [],
};

@State<CountiesStateModel>({
  name: 'counties',
  defaults: countiesDefaultStateModel,
})
export class CountiesState {
  constructor(private apollo: Apollo) {
  }

  @Selector()
  public static state(state: CountiesStateModel) {
    return state;
  }

  @Selector()
  public static items(state: CountiesStateModel) {
    return state.items;
  }

  @Selector()
  public static loading(state: CountiesStateModel) {
    return state.loading;
  }

  @Selector()
  public static stateId(state: CountiesStateModel) {
    return state.stateId;
  }

  @Action(CountiesResetAction)
  public reset(context: StateContext<CountiesStateModel>) {
    context.setState(countiesDefaultStateModel);
  }

  @Action(CountiesLoadAction)
  public async load(context: StateContext<CountiesStateModel>, {stateId}: CountiesLoadAction) {
    context.patchState({
      stateId,
      loading: true,
    });
    await this.apollo.query<StateQueryResponse>({query: stateQuery, variables: {stateId}})
      .pipe(map(({data}) => data.state.counties))
      .toPromise()
      .then(counties => {
        context.patchState({
          loading: false,
          items: counties,
        });
      });
  }
}
