import 'dart:async';
import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/db/comment_detail_dao.dart';
import 'package:fluttermultigrocery/viewobject/comment_detail.dart';
import 'package:flutter/material.dart';
import 'package:fluttermultigrocery/api/common/ps_resource.dart';
import 'package:fluttermultigrocery/api/common/ps_status.dart';
import 'package:fluttermultigrocery/api/ps_api_service.dart';
import 'package:sembast/sembast.dart';

import 'Common/ps_repository.dart';

class CommentDetailRepository extends PsRepository {
  CommentDetailRepository(
      {@required PsApiService psApiService,
      @required CommentDetailDao commentDetailDao}) {
    _psApiService = psApiService;
    _commentDetailDao = commentDetailDao;
  }

  String primaryKey = 'id';
  PsApiService _psApiService;
  CommentDetailDao _commentDetailDao;

  Future<dynamic> insert(CommentDetail commentHeader) async {
    return _commentDetailDao.insert(primaryKey, commentHeader);
  }

  Future<dynamic> update(CommentDetail commentHeader) async {
    return _commentDetailDao.update(commentHeader);
  }

  Future<dynamic> delete(CommentDetail commentHeader) async {
    return _commentDetailDao.delete(commentHeader);
  }

  Future<dynamic> getAllCommentDetailList(
      String headerId,
      StreamController<PsResource<List<CommentDetail>>> commentDetailListStream,
      bool isConnectedToInternet,
      int limit,
      int offset,
      PsStatus status,
      {bool isLoadFromServer = true}) async {
    final Finder finder = Finder(filter: Filter.equals('header_id', headerId));
    commentDetailListStream.sink
        .add(await _commentDetailDao.getAll(finder: finder, status: status));

    if (isConnectedToInternet) {
      final PsResource<List<CommentDetail>> _resource =
          await _psApiService.getCommentDetail(headerId, limit, offset);

      if (_resource.status == PsStatus.SUCCESS) {
        await _commentDetailDao.deleteWithFinder(finder);
        await _commentDetailDao.insertAll(primaryKey, _resource.data);
      } else {
        if (_resource.errorCode == PsConst.ERROR_CODE_10001) {
          await _commentDetailDao.deleteWithFinder(finder);
        }
      }
      commentDetailListStream.sink
          .add(await _commentDetailDao.getAll(finder: finder));
    }
  }

  Future<dynamic> getNextPageCommentDetailList(
      String headerId,
      StreamController<PsResource<List<CommentDetail>>> commentDetailListStream,
      bool isConnectedToInternet,
      int limit,
      int offset,
      PsStatus status,
      {bool isLoadFromServer = true}) async {
    final Finder finder = Finder(filter: Filter.equals('header_id', headerId));
    commentDetailListStream.sink
        .add(await _commentDetailDao.getAll(finder: finder, status: status));

    if (isConnectedToInternet) {
      final PsResource<List<CommentDetail>> _resource =
          await _psApiService.getCommentDetail(headerId, limit, offset);

      if (_resource.status == PsStatus.SUCCESS) {
        await _commentDetailDao.insertAll(primaryKey, _resource.data);
      }
      commentDetailListStream.sink
          .add(await _commentDetailDao.getAll(finder: finder));
    }
  }

  Future<PsResource<List<CommentDetail>>> postCommentDetail(
      StreamController<PsResource<List<CommentDetail>>> commentDetailListStream,
      Map<dynamic, dynamic> jsonMap,
      bool isConnectedToInternet,
      PsStatus status,
      {bool isLoadFromServer = true}) async {
    final PsResource<List<CommentDetail>> _resource =
        await _psApiService.postCommentDetail(jsonMap);
    if (_resource.status == PsStatus.SUCCESS) {
      return _resource;
    } else {
      final Completer<PsResource<List<CommentDetail>>> completer =
          Completer<PsResource<List<CommentDetail>>>();
      completer.complete(_resource);
      return completer.future;
    }
  }
}
