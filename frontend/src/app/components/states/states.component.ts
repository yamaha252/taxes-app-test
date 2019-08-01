import {Component, OnInit} from '@angular/core';
import {CountiesLoadAction} from '../../stores/counties/counties.actions';
import {Select, Store} from '@ngxs/store';
import {Observable} from 'rxjs';
import {StatesState} from '../../stores/states/states.state';
import {CountiesState} from '../../stores/counties/counties.state';
import {StateModel} from '../../models/state';

@Component({
  selector: 'app-states',
  templateUrl: './states.component.html',
  styleUrls: ['./states.component.css']
})
export class StatesComponent implements OnInit {

  @Select(StatesState.items)
  states$: Observable<StateModel[]>;

  @Select(StatesState.loading)
  loading$: Observable<boolean>;

  @Select(CountiesState.stateId)
  selectedId$: Observable<number>;

  displayedColumns: string[] = ['id', 'name', 'overallTaxAmount', 'averageTaxAmount', 'averageTaxRate'];

  constructor(private store: Store) {
  }

  ngOnInit() {
  }

  select(state: StateModel) {
    this.store.dispatch(new CountiesLoadAction(state.id));
  }
}
