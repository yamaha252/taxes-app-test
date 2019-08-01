import {Component, OnInit} from '@angular/core';
import {Select} from '@ngxs/store';
import {CountiesState} from '../../stores/counties/counties.state';
import {Observable} from 'rxjs';
import {CountyModel} from '../../models/county';

@Component({
  selector: 'app-counties',
  templateUrl: './counties.component.html',
  styleUrls: ['./counties.component.css']
})
export class CountiesComponent implements OnInit {

  @Select(CountiesState.items)
  counties$: Observable<CountyModel[]>;

  @Select(CountiesState.loading)
  loading$: Observable<boolean>;

  displayedColumns: string[] = ['id', 'name', 'taxRate', 'taxAmount'];

  constructor() {
  }

  ngOnInit() {
  }
}
