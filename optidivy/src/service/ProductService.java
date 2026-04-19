package service;

import model.ContactLense;
import model.Frame;
import model.Lense;
import model.WearPeriod;
import repository.FrameRepository;
import repository.WearPeriodRepository;
import repository.LenseRepository;
import repository.ContactLenseRepository;

import java.util.List;

public class ProductService {
    private FrameRepository frameRepository = new FrameRepository();
    private WearPeriodRepository wearPeriodRepository = new WearPeriodRepository();
    private ContactLenseRepository contactLenseRepository = new ContactLenseRepository();
    private LenseRepository lenseRepository = new LenseRepository();

    public List<Frame> getAllFrames() {
        return frameRepository.findAll();
    }

    public List<WearPeriod> getAllWearPeriods() {
        return wearPeriodRepository.findAll();
    }

    public List<ContactLense> getAllContactLenses() {
        return contactLenseRepository.findAll();
    }

    public List<Lense> getAllLenses() {
        return lenseRepository.findAll();
    }
}
