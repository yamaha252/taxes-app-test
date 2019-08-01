import { TestBed, async } from '@angular/core/testing';
import { NgxsModule, Store } from '@ngxs/store';
import { StatesState, StatesStateModel } from './states.state';
import { StatesAction } from './states.actions';

describe('States store', () => {
  let store: Store;
  beforeEach(async(() => {
    TestBed.configureTestingModule({
      imports: [NgxsModule.forRoot([StatesState])]
    }).compileComponents();
    store = TestBed.get(Store);
  }));

  it('should create an action and add an item', () => {
    const expected: StatesStateModel = {
      items: ['item-1']
    };
    store.dispatch(new StatesAction('item-1'));
    const actual = store.selectSnapshot(StatesState.getState);
    expect(actual).toEqual(expected);
  });

});
