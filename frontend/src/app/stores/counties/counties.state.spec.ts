import { TestBed, async } from '@angular/core/testing';
import { NgxsModule, Store } from '@ngxs/store';
import { CountiesState, CountiesStateModel } from './counties.state';
import { CountiesAction } from './counties.actions';

describe('Counties store', () => {
  let store: Store;
  beforeEach(async(() => {
    TestBed.configureTestingModule({
      imports: [NgxsModule.forRoot([CountiesState])]
    }).compileComponents();
    store = TestBed.get(Store);
  }));

  it('should create an action and add an item', () => {
    const expected: CountiesStateModel = {
      items: ['item-1']
    };
    store.dispatch(new CountiesAction('item-1'));
    const actual = store.selectSnapshot(CountiesState.getState);
    expect(actual).toEqual(expected);
  });

});
