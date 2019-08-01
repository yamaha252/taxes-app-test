import {TestBed, async} from '@angular/core/testing';
import {NgxsModule, Store} from '@ngxs/store';
import {StatesState} from './states.state';

describe('States store', () => {
  let store: Store;
  beforeEach(async(() => {
    TestBed.configureTestingModule({
      imports: [NgxsModule.forRoot([StatesState])]
    }).compileComponents();
    store = TestBed.get(Store);
  }));

  it('should init', () => {
    expect(store).toBeTruthy();
  });

});
