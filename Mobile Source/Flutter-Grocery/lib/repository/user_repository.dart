import 'dart:async';
import 'dart:io';
import 'package:fluttermultigrocery/db/user_dao.dart';
import 'package:fluttermultigrocery/db/user_login_dao.dart';
import 'package:fluttermultigrocery/viewobject/api_status.dart';
import 'package:fluttermultigrocery/viewobject/user.dart';
import 'package:fluttermultigrocery/viewobject/user_login.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/api/common/ps_resource.dart';
import 'package:fluttermultigrocery/api/common/ps_status.dart';
import 'package:fluttermultigrocery/api/ps_api_service.dart';
import 'package:fluttermultigrocery/repository/Common/ps_repository.dart';
import 'package:sembast/sembast.dart';

class UserRepository extends PsRepository {
  UserRepository(
      {@required PsApiService psApiService,
      @required UserDao userDao,
      UserLoginDao userLoginDao}) {
    _psApiService = psApiService;
    _userDao = userDao;
    _userLoginDao = userLoginDao;
  }

  PsApiService _psApiService;
  UserDao _userDao;
  UserLoginDao _userLoginDao;
  final String _userPrimaryKey = 'user_id';
  final String _userLoginPrimaryKey = 'map_key';

  void sinkUserDetailStream(StreamController<PsResource<User>> userListStream,
      PsResource<User> data) {
    if (data != null) {
      userListStream.sink.add(data);
    }
  }

  Future<dynamic> insert(User user) async {
    return _userDao.insert(_userPrimaryKey, user);
  }

  Future<dynamic> update(User user) async {
    return _userDao.update(user);
  }

  Future<dynamic> delete(User user) async {
    return _userDao.delete(user);
  }

  Future<dynamic> insertUserLogin(UserLogin user) async {
    return _userLoginDao.insert(_userLoginPrimaryKey, user);
  }

  Future<dynamic> updateUserLogin(UserLogin user) async {
    return _userLoginDao.update(user);
  }

  Future<dynamic> deleteUserLogin(UserLogin user) async {
    return _userLoginDao.delete(user);
  }

  Future<PsResource<User>> postUserRegister(Map<dynamic, dynamic> jsonMap,
      bool isConnectedToInternet, PsStatus status,
      {bool isLoadFromServer = true}) async {
    final PsResource<User> _resource =
        await _psApiService.postUserRegister(jsonMap);
    if (_resource.status == PsStatus.SUCCESS) {
      return _resource;
    } else {
      final Completer<PsResource<User>> completer =
          Completer<PsResource<User>>();
      completer.complete(_resource);
      return completer.future;
    }
  }

  Future<PsResource<User>> postUserLogin(Map<dynamic, dynamic> jsonMap,
      bool isConnectedToInternet, PsStatus status,
      {bool isLoadFromServer = true}) async {
    final PsResource<User> _resource =
        await _psApiService.postUserLogin(jsonMap);
    if (_resource.status == PsStatus.SUCCESS) {
      await _userLoginDao.deleteAll();
      await insert(_resource.data);
      final String userId = _resource.data.userId;
      final UserLogin userLogin =
          UserLogin(id: userId, login: true, user: _resource.data);
      await insertUserLogin(userLogin);
      return _resource;
    } else {
      final Completer<PsResource<User>> completer =
          Completer<PsResource<User>>();
      completer.complete(_resource);
      return completer.future;
    }
  }

  Future<dynamic> getUserLogin(String loginUserId,
      StreamController<dynamic> userLoginStream, PsStatus status) async {
    final Finder finder = Finder(filter: Filter.equals('id', loginUserId));

    userLoginStream.sink
        .add(await _userLoginDao.getOne(finder: finder, status: status));
  }

  Future<dynamic> getUserFromDB(String loginUserId,
      StreamController<dynamic> userStream, PsStatus status) async {
    final Finder finder =
        Finder(filter: Filter.equals(_userPrimaryKey, loginUserId));

    userStream.sink.add(await _userDao.getOne(finder: finder, status: status));
  }

  Future<PsResource<User>> postUserEmailVerify(Map<dynamic, dynamic> jsonMap,
      bool isConnectedToInternet, PsStatus status,
      {bool isLoadFromServer = true}) async {
    final PsResource<User> _resource =
        await _psApiService.postUserEmailVerify(jsonMap);
    if (_resource.status == PsStatus.SUCCESS) {
      await _userLoginDao.deleteAll();
      await insert(_resource.data);
      final String userId = _resource.data.userId;
      final UserLogin userLogin =
          UserLogin(id: userId, login: true, user: _resource.data);
      await insertUserLogin(userLogin);
      return _resource;
    } else {
      final Completer<PsResource<User>> completer =
          Completer<PsResource<User>>();
      completer.complete(_resource);
      return completer.future;
    }
  }

  Future<PsResource<User>> postImageUpload(String userId, String platformName,
      File imageFile, bool isConnectedToInternet, PsStatus status,
      {bool isLoadFromServer = true}) async {
    final PsResource<User> _resource =
        await _psApiService.postImageUpload(userId, platformName, imageFile);
    if (_resource.status == PsStatus.SUCCESS) {
      await _userLoginDao.deleteAll();
      await insert(_resource.data);
      final String userId = _resource.data.userId;
      final UserLogin userLogin =
          UserLogin(id: userId, login: true, user: _resource.data);
      await insertUserLogin(userLogin);
      return _resource;
    } else {
      final Completer<PsResource<User>> completer =
          Completer<PsResource<User>>();
      completer.complete(_resource);
      return completer.future;
    }
  }

  Future<PsResource<ApiStatus>> postForgotPassword(
      Map<dynamic, dynamic> jsonMap,
      bool isConnectedToInternet,
      PsStatus status,
      {bool isLoadFromServer = true}) async {
    final PsResource<ApiStatus> _resource =
        await _psApiService.postForgotPassword(jsonMap);
    if (_resource.status == PsStatus.SUCCESS) {
      return _resource;
    } else {
      final Completer<PsResource<ApiStatus>> completer =
          Completer<PsResource<ApiStatus>>();
      completer.complete(_resource);
      return completer.future;
    }
  }

  Future<PsResource<ApiStatus>> postChangePassword(
      Map<dynamic, dynamic> jsonMap,
      bool isConnectedToInternet,
      PsStatus status,
      {bool isLoadFromServer = true}) async {
    final PsResource<ApiStatus> _resource =
        await _psApiService.postChangePassword(jsonMap);
    if (_resource.status == PsStatus.SUCCESS) {
      return _resource;
    } else {
      final Completer<PsResource<ApiStatus>> completer =
          Completer<PsResource<ApiStatus>>();
      completer.complete(_resource);
      return completer.future;
    }
  }

  Future<PsResource<User>> postProfileUpdate(Map<dynamic, dynamic> jsonMap,
      bool isConnectedToInternet, PsStatus status,
      {bool isLoadFromServer = true}) async {
    final PsResource<User> _resource =
        await _psApiService.postProfileUpdate(jsonMap);
    if (_resource.status == PsStatus.SUCCESS) {
      await _userLoginDao.deleteAll();
      await insert(_resource.data);
      final String userId = _resource.data.userId;
      final UserLogin userLogin =
          UserLogin(id: userId, login: true, user: _resource.data);
      await insertUserLogin(userLogin);
      return _resource;
    } else {
      final Completer<PsResource<User>> completer =
          Completer<PsResource<User>>();
      completer.complete(_resource);
      return completer.future;
    }
  }

  Future<PsResource<User>> postPhoneLogin(Map<dynamic, dynamic> jsonMap,
      bool isConnectedToInternet, PsStatus status,
      {bool isLoadFromServer = true}) async {
    final PsResource<User> _resource =
        await _psApiService.postPhoneLogin(jsonMap);
    if (_resource.status == PsStatus.SUCCESS) {
      await _userLoginDao.deleteAll();
      await insert(_resource.data);
      final String userId = _resource.data.userId;
      final UserLogin userLogin =
          UserLogin(id: userId, login: true, user: _resource.data);
      await insertUserLogin(userLogin);
      return _resource;
    } else {
      final Completer<PsResource<User>> completer =
          Completer<PsResource<User>>();
      completer.complete(_resource);
      return completer.future;
    }
  }

  Future<PsResource<User>> postFBLogin(Map<dynamic, dynamic> jsonMap,
      bool isConnectedToInternet, PsStatus status,
      {bool isLoadFromServer = true}) async {
    final PsResource<User> _resource = await _psApiService.postFBLogin(jsonMap);
    if (_resource.status == PsStatus.SUCCESS) {
      await _userLoginDao.deleteAll();
      await insert(_resource.data);
      final String userId = _resource.data.userId;
      final UserLogin userLogin =
          UserLogin(id: userId, login: true, user: _resource.data);
      await insertUserLogin(userLogin);
      return _resource;
    } else {
      final Completer<PsResource<User>> completer =
          Completer<PsResource<User>>();
      completer.complete(_resource);
      return completer.future;
    }
  }

  Future<PsResource<User>> postGoogleLogin(Map<dynamic, dynamic> jsonMap,
      bool isConnectedToInternet, PsStatus status,
      {bool isLoadFromServer = true}) async {
    final PsResource<User> _resource =
        await _psApiService.postGoogleLogin(jsonMap);
    if (_resource.status == PsStatus.SUCCESS) {
      await _userLoginDao.deleteAll();
      await insert(_resource.data);
      final String userId = _resource.data.userId;
      final UserLogin userLogin =
          UserLogin(id: userId, login: true, user: _resource.data);
      await insertUserLogin(userLogin);
      return _resource;
    } else {
      final Completer<PsResource<User>> completer =
          Completer<PsResource<User>>();
      completer.complete(_resource);
      return completer.future;
    }
  }

  Future<PsResource<User>> postAppleLogin(Map<dynamic, dynamic> jsonMap,
      bool isConnectedToInternet, PsStatus status,
      {bool isLoadFromServer = true}) async {
    final PsResource<User> _resource =
        await _psApiService.postAppleLogin(jsonMap);
    if (_resource.status == PsStatus.SUCCESS) {
      await _userLoginDao.deleteAll();
      await insert(_resource.data);
      final String userId = _resource.data.userId;
      final UserLogin userLogin =
          UserLogin(id: userId, login: true, user: _resource.data);
      await insertUserLogin(userLogin);
      return _resource;
    } else {
      final Completer<PsResource<User>> completer =
          Completer<PsResource<User>>();
      completer.complete(_resource);
      return completer.future;
    }
  }

  Future<PsResource<ApiStatus>> postResendCode(Map<dynamic, dynamic> jsonMap,
      bool isConnectedToInternet, PsStatus status,
      {bool isLoadFromServer = true}) async {
    final PsResource<ApiStatus> _resource =
        await _psApiService.postResendCode(jsonMap);
    if (_resource.status == PsStatus.SUCCESS) {
      return _resource;
    } else {
      final Completer<PsResource<ApiStatus>> completer =
          Completer<PsResource<ApiStatus>>();
      completer.complete(_resource);
      return completer.future;
    }
  }

  Future<dynamic> getUser(StreamController<PsResource<User>> userListStream,
      String loginUserId, bool isConnectedToInternet, PsStatus status,
      {bool isLoadFromServer = true}) async {
    final Finder finder = Finder(filter: Filter.equals('user_id', loginUserId));
    sinkUserDetailStream(
        userListStream, await _userDao.getOne(finder: finder, status: status));

    if (isConnectedToInternet) {
      final PsResource<List<User>> _resource =
          await _psApiService.getUser(loginUserId);

      if (_resource.status == PsStatus.SUCCESS) {
        await _userDao.deleteWithFinder(finder);
        await _userDao.insertAll(_userPrimaryKey, _resource.data);
      }
      sinkUserDetailStream(
          userListStream, await _userDao.getOne(finder: finder));
    }
  }
}
