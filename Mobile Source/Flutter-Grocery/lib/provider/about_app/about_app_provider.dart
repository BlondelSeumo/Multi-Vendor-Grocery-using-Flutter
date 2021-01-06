import 'dart:async';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/api/common/ps_resource.dart';
import 'package:fluttermultigrocery/api/common/ps_status.dart';
import 'package:fluttermultigrocery/provider/common/ps_provider.dart';
import 'package:fluttermultigrocery/repository/about_app_repository.dart';
import 'package:fluttermultigrocery/utils/utils.dart';
import 'package:fluttermultigrocery/viewobject/about_app.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_value_holder.dart';

class AboutAppProvider extends PsProvider {
  AboutAppProvider(
      {@required AboutAppRepository repo,
      @required this.psValueHolder,
      int limit = 0})
      : super(repo, limit) {
    _repo = repo;

    print('about us Provider: $hashCode');

    Utils.checkInternetConnectivity().then((bool onValue) {
      isConnectedToInternet = onValue;
    });
    aboutAppListStream =
        StreamController<PsResource<List<AboutApp>>>.broadcast();
    subscription =
        aboutAppListStream.stream.listen((PsResource<List<AboutApp>> resource) {
      updateOffset(resource.data.length);

      _aboutAppList = resource;

      if (resource.status != PsStatus.BLOCK_LOADING &&
          resource.status != PsStatus.PROGRESS_LOADING) {
        isLoading = false;
      }

      if (!isDispose) {
        notifyListeners();
      }
    });
  }

  AboutAppRepository _repo;
  PsValueHolder psValueHolder;
  PsResource<List<AboutApp>> _aboutAppList =
      PsResource<List<AboutApp>>(PsStatus.NOACTION, '', <AboutApp>[]);

  PsResource<List<AboutApp>> get aboutAppList => _aboutAppList;
  StreamSubscription<PsResource<List<AboutApp>>> subscription;
  StreamController<PsResource<List<AboutApp>>> aboutAppListStream;
  @override
  void dispose() {
    subscription.cancel();
    isDispose = true;
    print('AboutApp Provider Dispose: $hashCode');
    super.dispose();
  }

  Future<dynamic> loadAboutAppList() async {
    isLoading = true;

    isConnectedToInternet = await Utils.checkInternetConnectivity();
    await _repo.getAllAboutAppList(
        aboutAppListStream, isConnectedToInternet, PsStatus.PROGRESS_LOADING);
  }

  Future<dynamic> nextAboutAppList() async {
    isConnectedToInternet = await Utils.checkInternetConnectivity();

    if (!isLoading && !isReachMaxData) {
      super.isLoading = true;
      await _repo.getNextPageAboutAppList(
          aboutAppListStream, isConnectedToInternet, PsStatus.PROGRESS_LOADING);
    }
  }

  Future<void> resetAboutAppList() async {
    isConnectedToInternet = await Utils.checkInternetConnectivity();
    isLoading = true;

    updateOffset(0);

    await _repo.getAllAboutAppList(
        aboutAppListStream, isConnectedToInternet, PsStatus.PROGRESS_LOADING);

    isLoading = false;
  }
}
