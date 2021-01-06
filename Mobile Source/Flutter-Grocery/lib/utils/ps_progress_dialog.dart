import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/config/ps_colors.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:progress_dialog/progress_dialog.dart';

class PsProgressDialog {
  PsProgressDialog._();

  static ProgressDialog _progressDialog;

  static Future<bool> showDialog(BuildContext context, {String message}) async {
    if (_progressDialog == null) {
      _progressDialog = ProgressDialog(context,
          type: ProgressDialogType.Normal,
          isDismissible: false,
          showLogs: true);

      _progressDialog.style(
          message:
              message ?? Utils.getString(context, 'loading_dialog__loading'),
          borderRadius: 5.0,
          backgroundColor: Utils.isLightMode(context)
              ? PsColors.white
              : PsColors.backgroundColor,
          progressWidget: Container(
              padding: const EdgeInsets.all(10.0),
              child: const CircularProgressIndicator()),
          elevation: 10.0,
          insetAnimCurve: Curves.easeInOut,
          progress: 0.0,
          maxProgress: 100.0,
          progressTextStyle: Theme.of(context)
              .textTheme
              .bodyText2
              .copyWith(color: PsColors.mainColor),
          messageTextStyle: Theme.of(context)
              .textTheme
              .bodyText2
              .copyWith(color: PsColors.mainColor));
    }

    if (message != null) {
      _progressDialog.update(
          message:
              message ?? Utils.getString(context, 'loading_dialog__loading'));
    }

    await _progressDialog.show();

    return true;
  }

  static void dismissDialog() {
    if (_progressDialog != null) {
      _progressDialog.hide();
      _progressDialog = null;
    }
  }

  static bool isShowing() {
    if (_progressDialog != null) {
      return _progressDialog.isShowing();
    } else {
      return false;
    }
  }

  static Future<bool> showDownloadDialog(BuildContext context, double progress,
      {String message}) async {
    if (_progressDialog == null) {
      _progressDialog = ProgressDialog(context,
          type: ProgressDialogType.Download,
          isDismissible: false,
          showLogs: true);

      _progressDialog.style(
          message:
              message ?? Utils.getString(context, 'loading_dialog__loading'),
          borderRadius: 5.0,
          backgroundColor: PsColors.white,
          progressWidget: Container(
              padding: const EdgeInsets.all(10.0),
              child: const CircularProgressIndicator()),
          elevation: 10.0,
          insetAnimCurve: Curves.easeInOut,
          progress: progress,
          maxProgress: 100.0,
          progressTextStyle: Theme.of(context).textTheme.bodyText2,
          messageTextStyle: Theme.of(context).textTheme.bodyText2);
    }

    _progressDialog.update(
        message: message ?? Utils.getString(context, 'loading_dialog__loading'),
        progress: progress);

    if (!_progressDialog.isShowing()) {
      await _progressDialog.show();
    }
    return true;
  }

  static void dismissDownloadDialog() {
    if (_progressDialog != null) {
      _progressDialog.hide();
      _progressDialog = null;
    }
  }
}
