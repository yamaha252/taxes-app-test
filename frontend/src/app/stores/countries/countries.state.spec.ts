import { TestBed, async } from '@angular/core/testing';
import { NgxsModule, Store } from '@ngxs/store';
import { CountriesState, CountriesStateModel } from './countries.state';
import { CountriesAction } from './countries.actions';

describe('Countries store', () => {
  let store: Store;
  beforeEach(async(() => {
    TestBed.configureTestingModule({
      imports: [NgxsModule.forRoot([CountriesState])]
    }).compileComponents();
    store = TestBed.get(Store);
  }));

  it('should create an action and add an item', () => {
    const expected: CountriesStateModel = {
      items: ['item-1']
    };
    store.dispatch(new CountriesAction('item-1'));
    const actual = store.selectSnapshot(CountriesState.getState);
    expect(actual).toEqual(expected);
  });

});
