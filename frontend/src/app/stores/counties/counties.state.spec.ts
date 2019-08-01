import {TestBed, async} from '@angular/core/testing';
import {NgxsModule, Store} from '@ngxs/store';
import {CountiesState} from './counties.state';

describe('Counties store', () => {
  let store: Store;
  beforeEach(async(() => {
    TestBed.configureTestingModule({
      imports: [NgxsModule.forRoot([CountiesState])]
    }).compileComponents();
    store = TestBed.get(Store);
  }));

  it('should init', () => {
    expect(store).toBeTruthy();
  });

});
