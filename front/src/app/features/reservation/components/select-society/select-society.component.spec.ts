import { HttpClientModule } from '@angular/common/http';
import { ComponentFixture, TestBed } from '@angular/core/testing';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatSelectModule } from '@angular/material/select';
import { NoopAnimationsModule } from '@angular/platform-browser/animations';
import { HttpService } from '../../services/http.service';

import { SelectSocietyComponent } from './select-society.component';

describe('SelectSocietyComponent', () => {
  let component: SelectSocietyComponent;
  let fixture: ComponentFixture<SelectSocietyComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ReactiveFormsModule, FormsModule, HttpClientModule, MatFormFieldModule, MatInputModule, MatSelectModule, MatButtonModule, NoopAnimationsModule],
      declarations: [ SelectSocietyComponent ],
      providers: [HttpService],
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(SelectSocietyComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
