import { Component, OnInit } from '@angular/core';
import { FileUploadService } from '@app/services/file-upload.service';
import { LoginService } from '@app/services/login/login.service';
import { UserService } from '@app/services/user.service';

@Component({
  selector: 'app-avatar',
  templateUrl: './avatar.component.html',
  styleUrls: ['./avatar.component.scss'],
})
export class AvatarComponent implements OnInit {
  user: any;
  file: any;
  isLoading = false;
  showSuccessAlert = false;
  showErrorAlert = false;
  errors: any = {};

  constructor(
    private loginService: LoginService,
    private fileUploadService: FileUploadService,
    private userService: UserService
  ) {}

  ngOnInit(): void {
    this.loginService.currentUser.subscribe((user) => {
      this.user = user;
    });
  }

  changeAvatar() {
    var formData: FormData = new FormData();
    formData.append('file', this.file);
    this.isLoading = true;

    this.fileUploadService.upload(formData).subscribe(
      (file) => {
        this.user.avatar = file.path;
        this.userService
          .update(this.user.id, {
            avatar: this.user.avatar,
          })
          .subscribe(
            (user) => {
              this.loginService.updateCurrentUser(user);
              this.isLoading = false;
              this.showSuccessAlert = true;
              setTimeout(() => {
                this.showSuccessAlert = false;
              }, 5000);
            },
            ({ error }) => {
              this.errors = error.errors;
              this.isLoading = false;
              this.showErrorAlert = true;
              setTimeout(() => {
                this.showErrorAlert = false;
              }, 5000);
            }
          );
      },
      ({ error }) => {
        this.errors = error.errors;
        this.isLoading = false;
      }
    );
  }

  onChange(e: any) {
    this.file = e.target.files[0];
  }
}
